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

/* $Id: edit_profile.php,v 1.114 2010-01-17 11:37:17 decoyduck Exp $ */

// Set the default timezone
date_default_timezone_set('UTC');

/**
* Displays the edit profile page, and processes sumbissions
*/

/**
*/

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
include_once(BH_INCLUDE_PATH. "user.inc.php");
include_once(BH_INCLUDE_PATH. "user_profile.inc.php");
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

// Check to see if the user has been approved.

if (!bh_session_user_approved()) {

    html_user_require_approval();
    exit;
}

// Check we have a webtag

if (!forum_check_webtag_available($webtag)) {
    $request_uri = rawurlencode(get_request_uri(false));
    header_redirect("forums.php?webtag_error&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("forums.php?webtag_error&final_uri=$request_uri");
}

if (user_is_guest()) {

    html_guest_error();
    exit;
}

$admin_edit = false;

if (bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0)) {

    if (isset($_GET['profileuid'])) {

        if (is_numeric($_GET['profileuid'])) {

            $uid = $_GET['profileuid'];
            $admin_edit = true;

        }else {

            html_draw_top("title={$lang['error']}");
            html_error_msg($lang['nouserspecified']);
            html_draw_bottom();
            exit;
        }

    }elseif (isset($_POST['profileuid'])) {

        if (is_numeric($_POST['profileuid'])) {

            $uid = $_POST['profileuid'];
            $admin_edit = true;

        }else {

            html_draw_top("title={$lang['error']}");
            html_error_msg($lang['nouserspecified']);
            html_draw_bottom();
            exit;
        }

    }else {

        $uid = bh_session_get_value('UID');
    }

    if (isset($_POST['cancel'])) {

        header_redirect("admin_user.php?webtag=$webtag&uid=$uid");
        exit;
    }

}else {

    $uid = bh_session_get_value('UID');
}

if (!(bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0)) && ($uid != bh_session_get_value('UID'))) {

    html_draw_top("title={$lang['error']}");
    html_error_msg($lang['accessdeniedexp']);
    html_draw_bottom();
    exit;
}

// Fetch array of profile items.

$profile_items_array = profile_get_user_values($uid);

// Array to hold error messages

$error_msg_array = array();

// Do updates

if (isset($_POST['save'])) {

    $valid = true;

    if (isset($_POST['t_entry']) && is_array($_POST['t_entry'])) {

        $t_entry_array = $_POST['t_entry'];

        $t_entry_cleaned_array = array_map('strip_tags', $t_entry_array);

        if (sizeof(array_diff_assoc($t_entry_array, $t_entry_cleaned_array)) > 0) {

            $error_msg_array[] = $lang['profileentriesmustnotincludehtml'];
            $valid = false;
        }

        if ($valid) {

            foreach ($t_entry_array as $piid => $profile_entry) {

                $profile_entry = trim(stripslashes_array($profile_entry));

                if ($admin_edit) {

                    $privacy = (isset($profile_items_array[$piid]['PRIVACY']) ? $profile_items_array[$piid]['PRIVACY'] : 0);

                }elseif (isset($_POST['t_entry_private'][$piid]) && $_POST['t_entry_private'][$piid] == 'Y') {

                    $privacy = PROFILE_ITEM_PRIVATE;

                }else {

                    $privacy = PROFILE_ITEM_PUBLIC;
                }

                if (!user_profile_update($uid, $piid, $profile_entry, $privacy)) {

                    $error_msg_array[] = $lang['failedtoupdateuserprofile'];
                    $valid = false;
                }
            }

            if ($valid) {

                if ($admin_edit === true) {

                    header_redirect("admin_user.php?webtag=$webtag&uid=$uid&profile_updated=true", $lang['profileupdated']);
                    exit;

                }else {

                    header_redirect("edit_profile.php?webtag=$webtag&uid=$uid&profile_updated=true", $lang['profileupdated']);
                    exit;
                }
            }
        }
    }
}

if (is_array($profile_items_array) && sizeof($profile_items_array) > 0) {

    if ($admin_edit === true) {

        $user = user_get($uid);

        html_draw_top("title={$lang['admin']} » {$lang['editprofile']} » ". format_user_name($user['LOGON'], $user['NICKNAME']));

        echo "<h1>{$lang['admin']} &raquo; {$lang['editprofile']} &raquo; ", format_user_name($user['LOGON'], $user['NICKNAME']), "</h1>\n";

    }else {

        html_draw_top("title={$lang['mycontrols']} » {$lang['editprofile']}");

        echo "<h1>{$lang['editprofile']}</h1>\n";
    }

    if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

        html_display_error_array($error_msg_array, '600', ($admin_edit) ? 'center' : 'left');

    }elseif (isset($_GET['profile_updated'])) {

        html_display_success_msg($lang['profileupdated'], '600', ($admin_edit) ? 'center' : 'left');
    }

    if ($admin_edit === true) echo "<div align=\"center\">\n";

    echo "<br />\n";
    echo "<form accept-charset=\"utf-8\" name=\"f_profile\" action=\"edit_profile.php\" method=\"post\" target=\"_self\">\n";
    echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";

    if ($admin_edit === true) echo "  ", form_input_hidden('profileuid', htmlentities_array($uid)), "\n";

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

    foreach ($profile_items_array as $profile_item) {

        if (!isset($profile_item['ENTRY'])) $profile_item['ENTRY'] = '';

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
                echo "                        <td align=\"left\" class=\"subhead\" colspan=\"3\">{$profile_item['SECTION_NAME']}</td>\n";
                echo "                        <td align=\"left\" class=\"subhead\" width=\"1%\">&nbsp;</td>\n";
                echo "                      </tr>\n";

            }else {

                echo "                      <tr>\n";
                echo "                        <td align=\"left\" class=\"subhead\" colspan=\"3\">{$profile_item['SECTION_NAME']}</td>\n";
                echo "                        <td align=\"left\" class=\"subhead\" width=\"1%\">&nbsp;</td>\n";
                echo "                      </tr>\n";
            }
        }

        $last_psid = $profile_item['PSID'];

        echo "                      <tr>\n";
        echo "                        <td align=\"left\">&nbsp;</td>\n";
        echo "                        <td align=\"left\" width=\"225\">{$profile_item['ITEM_NAME']}</td>\n";

        if (($profile_item['TYPE'] == PROFILE_ITEM_RADIO) || ($profile_item['TYPE'] == PROFILE_ITEM_DROPDOWN)) {

            $profile_item_options_array = htmlentities_array(explode("\n", $profile_item['OPTIONS']));

            profile_item_add_clear_entry($profile_item_options_array, $profile_item['TYPE']);

            if ($profile_item['TYPE'] == PROFILE_ITEM_RADIO) {
                echo "                        <td align=\"left\" valign=\"top\">", form_radio_array("t_entry[{$profile_item['PIID']}]", $profile_item_options_array, (isset($t_entry_array[$profile_item['PIID']]) ? htmlentities_array($t_entry_array[$profile_item['PIID']]) : htmlentities_array($profile_item['ENTRY']))), "</td>\n";
            }else {
                echo "                        <td align=\"left\" valign=\"top\">", form_dropdown_array("t_entry[{$profile_item['PIID']}]", $profile_item_options_array, (isset($t_entry_array[$profile_item['PIID']]) ? htmlentities_array($t_entry_array[$profile_item['PIID']]) : htmlentities_array($profile_item['ENTRY'])), false, 'bhinputprofileitem'), "</td>\n";
            }

            if ($admin_edit === false) {
                echo "                        <td align=\"right\" valign=\"top\">", form_checkbox("t_entry_private[{$profile_item['PIID']}]", "Y", '', (isset($profile_item['PRIVACY']) && $profile_item['PRIVACY'] == PROFILE_ITEM_PRIVATE), "title=\"{$lang['friendsonly']}\""), "</td>\n";
            }else {
                echo "                        <td align=\"left\" valign=\"top\">&nbsp;</td>\n";
            }

        }elseif ($profile_item['TYPE'] == PROFILE_ITEM_MULTI_TEXT) {

            echo "                        <td align=\"left\" valign=\"top\">", form_textarea("t_entry[{$profile_item['PIID']}]", (isset($t_entry_array[$profile_item['PIID']]) ? htmlentities_array($t_entry_array[$profile_item['PIID']]) : htmlentities_array($profile_item['ENTRY'])), false, false, false, 'bhinputprofileitem'), "</td>\n";

            if ($admin_edit === false) {
                echo "                        <td align=\"right\" valign=\"top\">", form_checkbox("t_entry_private[{$profile_item['PIID']}]", "Y", '', (isset($profile_item['PRIVACY']) && $profile_item['PRIVACY'] == PROFILE_ITEM_PRIVATE), "title=\"{$lang['friendsonly']}\""), "</td>\n";
            }else {
                echo "                        <td align=\"left\" valign=\"top\">&nbsp;</td>\n";
            }

            echo "                      </tr>\n";

        }else {

            echo "                        <td align=\"left\" valign=\"top\">", form_input_text("t_entry[{$profile_item['PIID']}]", (isset($t_entry_array[$profile_item['PIID']]) ? htmlentities_array($t_entry_array[$profile_item['PIID']]) : htmlentities_array($profile_item['ENTRY'])), false, false, false, 'bhinputprofileitem'), "</td>\n";

            if ($admin_edit === false) {
                echo "                        <td align=\"right\" valign=\"top\">", form_checkbox("t_entry_private[{$profile_item['PIID']}]", "Y", '', (isset($profile_item['PRIVACY']) && $profile_item['PRIVACY'] == PROFILE_ITEM_PRIVATE), "title=\"{$lang['friendsonly']}\""), "</td>\n";
            }else {
                echo "                        <td align=\"left\" valign=\"top\">&nbsp;</td>\n";
            }
        }

        echo "                      </tr>\n";
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
        echo "            <td align=\"center\">", form_submit("save", $lang['save']), "&nbsp;", form_submit("cancel", $lang['cancel']), "</td>\n";
        echo "          </tr>\n";

    }else {

        echo "          <tr>\n";
        echo "            <td align=\"center\">", form_submit("save", $lang['save']), "</td>\n";
        echo "          </tr>\n";
    }

    echo "        </table>\n";
    echo "      </td>\n";
    echo "    </tr>\n";
    echo "  </table>\n";
    echo "</form>\n";

    if ($admin_edit === true) echo "</div>\n";

    html_draw_bottom();

}else {

    html_draw_top("title={$lang['error']}");
    html_error_msg($lang['profilesnotsetup']);
    html_draw_bottom();
}

?>