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

/* $Id: pm_options.php,v 1.14 2008-07-27 18:26:11 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

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

// Fetch Forum Settings

$forum_settings = forum_get_settings();

// Fetch Global Forum Settings

$forum_global_settings = forum_get_global_settings();

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "emoticons.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "post.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "styles.inc.php");
include_once(BH_INCLUDE_PATH. "timezone.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    $webtag = get_webtag();
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

// Fetch the webtag

$webtag = get_webtag();

// Load language file

$lang = load_language_file();

// Guests can't access this page.

if (user_is_guest()) {

    html_guest_error();
    exit;
}

// Array to hold error messages.

$error_msg_array = array();

// Submit code starts here.

if (isset($_POST['save'])) {

    $user_prefs = array();
    $user_prefs_global = array();

    if (isset($_POST['pm_notify']) && $_POST['pm_notify'] == "Y") {
        $user_prefs['PM_NOTIFY'] = "Y";
    }else {
        $user_prefs['PM_NOTIFY'] = "N";
    }

    if (isset($_POST['pm_save_sent_items']) && $_POST['pm_save_sent_items'] == "Y") {
        $user_prefs['PM_SAVE_SENT_ITEM'] = "Y";
    }else {
        $user_prefs['PM_SAVE_SENT_ITEM'] = "N";
    }

    if (isset($_POST['pm_include_reply']) && $_POST['pm_include_reply'] == "Y") {
        $user_prefs['PM_INCLUDE_REPLY'] = "Y";
    } else {
        $user_prefs['PM_INCLUDE_REPLY'] = "N";
    }

    if (isset($_POST['pm_auto_prune_enabled']) && $_POST['pm_auto_prune_enabled'] == "Y") {

        if (isset($_POST['pm_auto_prune']) && is_numeric($_POST['pm_auto_prune'])) {

            $user_prefs['PM_AUTO_PRUNE'] = $_POST['pm_auto_prune'];

        }else {

            $user_prefs['PM_AUTO_PRUNE'] = "-60";
        }

    }else {

        if (isset($_POST['pm_auto_prune']) && is_numeric($_POST['pm_auto_prune'])) {

            $user_prefs['PM_AUTO_PRUNE'] = $_POST['pm_auto_prune'] * -1;

        }else {

            $user_prefs['PM_AUTO_PRUNE'] = "-60";
        }
    }

    if (isset($_POST['pm_export_file']) && is_numeric($_POST['pm_export_file'])) {
        $user_prefs['PM_EXPORT_FILE'] = $_POST['pm_export_file'];
    }else {
        $user_prefs['PM_EXPORT_FILE'] = 0;
    }

    if (isset($_POST['pm_export_type']) && is_numeric($_POST['pm_export_type'])) {
        $user_prefs['PM_EXPORT_TYPE'] = $_POST['pm_export_type'];
    }else {
        $user_prefs['PM_EXPORT_TYPE'] = 0;
    }

    if (isset($_POST['pm_export_attachments']) && $_POST['pm_export_attachments'] == "Y") {
        $user_prefs['PM_EXPORT_ATTACHMENTS'] = "Y";
    }else {
        $user_prefs['PM_EXPORT_ATTACHMENTS'] = "N";
    }

    if (isset($_POST['pm_export_style']) && $_POST['pm_export_style'] == "Y") {
        $user_prefs['PM_EXPORT_STYLE'] = "Y";
    }else {
        $user_prefs['PM_EXPORT_STYLE'] = "N";
    }

    if (isset($_POST['pm_export_wordfilter']) && $_POST['pm_export_wordfilter'] == "Y") {
        $user_prefs['PM_EXPORT_WORDFILTER'] = "Y";
    }else {
        $user_prefs['PM_EXPORT_WORDFILTER'] = "N";
    }

    // User's UID for updating with.

    $uid = bh_session_get_value('UID');

    // Update USER_PREFS

    if (user_update_prefs($uid, $user_prefs, $user_prefs_global)) {

        // Reinitialize the User's Session to save them having to logout and back in

        bh_session_init($uid, false);

        // Redirect back to the page so we correctly reload the user's preferences.

        header_redirect("pm_options.php?webtag=$webtag&updated=true", $lang['preferencesupdated']);
        exit;

    }else {

        $error_msg_array[] = $lang['failedtoupdateuserdetails'];
        $valid = false;
    }
}

if (!isset($uid)) $uid = bh_session_get_value('UID');

// Get User Prefs

$user_prefs = user_get_prefs($uid);

// Start output here

html_draw_top("emoticons.js");

echo "<h1>{$lang['privatemessageoptions']}</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

    html_display_error_array($error_msg_array, '600', 'left');

}else if (isset($_GET['updated'])) {

    html_display_success_msg($lang['preferencesupdated'], '600', 'left');
}

echo "<br />\n";
echo "<form name=\"prefs\" action=\"pm_options.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"2\" class=\"subhead\">{$lang['privatemessageoptions']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" rowspan=\"6\" width=\"1%\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("pm_notify", "Y", $lang['notifyofnewpm'], (isset($user_prefs['PM_NOTIFY']) && $user_prefs['PM_NOTIFY'] == "Y") ? true : false), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("pm_save_sent_items", "Y", $lang['savepminsentitems'], (isset($user_prefs['PM_SAVE_SENT_ITEM']) && $user_prefs['PM_SAVE_SENT_ITEM'] == "Y") ? true : false), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("pm_include_reply", "Y", $lang['includepminreply'], (isset($user_prefs['PM_INCLUDE_REPLY']) && $user_prefs['PM_INCLUDE_REPLY'] == "Y") ? true : false), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("pm_auto_prune_enabled", "Y", $lang['autoprunemypmfoldersevery'], (isset($user_prefs['PM_AUTO_PRUNE']) && $user_prefs['PM_AUTO_PRUNE'] > 0) ? true : false), "&nbsp;", form_dropdown_array('pm_auto_prune', array(1 => 10, 2 => 15, 3 => 30, 4 => 60), (isset($user_prefs['PM_AUTO_PRUNE']) ? ($user_prefs['PM_AUTO_PRUNE'] > 0 ? $user_prefs['PM_AUTO_PRUNE'] : $user_prefs['PM_AUTO_PRUNE'] * -1) : 60)), " {$lang['days']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "        <br />\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"3\" class=\"subhead\">{$lang['privatemessageexportoptions']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" rowspan=\"7\" width=\"1%\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" width=\"250\" nowrap=\"nowrap\">{$lang['pmexportastype']}:</td>\n";
echo "                  <td align=\"left\">", form_dropdown_array("pm_export_type", array($lang['pmexporthtml'], $lang['pmexportxml'], $lang['pmexportplaintext']), (isset($user_prefs['PM_EXPORT_TYPE']) && is_numeric($user_prefs['PM_EXPORT_TYPE'])) ? $user_prefs['PM_EXPORT_TYPE'] : 0), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" width=\"250\" nowrap=\"nowrap\">{$lang['pmexportmessagesas']}:</td>\n";
echo "                  <td align=\"left\">", form_dropdown_array("pm_export_file", array($lang['pmexportonefileforallmessages'], $lang['pmexportonefilepermessage']), (isset($user_prefs['PM_EXPORT_FILE']) && is_numeric($user_prefs['PM_EXPORT_FILE'])) ? $user_prefs['PM_EXPORT_FILE'] : 0), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"2\" nowrap=\"nowrap\">", form_checkbox("pm_export_attachments", "Y", $lang['pmexportattachments'], (isset($user_prefs['PM_EXPORT_ATTACHMENTS']) && $user_prefs['PM_EXPORT_ATTACHMENTS'] == "Y") ? true : false), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"2\" nowrap=\"nowrap\">", form_checkbox("pm_export_style", "Y", $lang['pmexportincludestyle'], (isset($user_prefs['PM_EXPORT_STYLE']) && $user_prefs['PM_EXPORT_STYLE'] == "Y") ? true : false), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"2\" nowrap=\"nowrap\">", form_checkbox("pm_export_wordfilter", "Y", $lang['pmexportwordfilter'], (isset($user_prefs['PM_EXPORT_WORDFILTER']) && $user_prefs['PM_EXPORT_WORDFILTER'] == "Y") ? true : false), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"2\">&nbsp;</td>\n";
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
echo "      <td align=\"center\">", form_submit("save", $lang['save']), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";

html_draw_bottom();

?>