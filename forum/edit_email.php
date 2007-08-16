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

/* $Id: edit_email.php,v 1.75 2007-08-16 15:38:12 decoyduck Exp $ */

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

// Fetch Forum Settings

$forum_settings = forum_get_settings();

// Fetch Global Forum Settings

$forum_global_settings = forum_get_global_settings();

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "fixhtml.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "post.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

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
    $request_uri = rawurlencode(get_request_uri(false));
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

if (user_is_guest()) {

    html_guest_error();
    exit;
}

// Array to hold error messages

$error_msg_array = array();

// Submit code

if (isset($_POST['submit'])) {

    $user_prefs = array();
    $user_prefs_global = array();

    if (isset($_POST['allow_email']) && $_POST['allow_email'] == "Y") {
        $user_prefs['ALLOW_EMAIL'] = "Y";
    }else {
        $user_prefs['ALLOW_EMAIL'] = "N";
    }

    if (isset($_POST['allow_email_global'])) {
        $user_prefs_global['ALLOW_EMAIL'] = ($_POST['allow_email_global'] == "Y") ? true : false;
    } else {
        $user_prefs_global['ALLOW_EMAIL'] = false;
    }

    if (isset($_POST['allow_pm']) && $_POST['allow_pm'] == "Y") {
        $user_prefs['ALLOW_PM'] = "Y";
    }else {
        $user_prefs['ALLOW_PM'] = "N";
    }

    if (isset($_POST['allow_pm_global'])) {
        $user_prefs_global['ALLOW_PM'] = ($_POST['allow_pm_global'] == "Y") ? true : false;
    } else {
        $user_prefs_global['ALLOW_PM'] = false;
    }

    if (isset($_POST['email_notify']) && $_POST['email_notify'] == "Y") {
        $user_prefs['EMAIL_NOTIFY'] = "Y";
    }else {
        $user_prefs['EMAIL_NOTIFY'] = "N";
    }

    if (isset($_POST['email_notify_global'])) {
        $user_prefs_global['EMAIL_NOTIFY'] = ($_POST['email_notify_global'] == "Y") ? true : false;
    } else {
        $user_prefs_global['EMAIL_NOTIFY'] = false;
    }

    if (isset($_POST['pm_notify_email']) && $_POST['pm_notify_email'] == "Y") {
        $user_prefs['PM_NOTIFY_EMAIL'] = "Y";
    }else {
        $user_prefs['PM_NOTIFY_EMAIL'] = "N";
    }

    if (isset($_POST['anon_logon']) && is_numeric($_POST['anon_logon'])) {
        $user_prefs['ANON_LOGON'] = $_POST['anon_logon'];
    }else {
        $user_prefs['ANON_LOGON'] = 0;
    }

    if (isset($_POST['anon_logon_global'])) {
        $user_prefs_global['ANON_LOGON'] = ($_POST['anon_logon_global'] == "Y") ? true : false;
    } else {
        $user_prefs_global['ANON_LOGON'] = false;
    }

    if (isset($_POST['dob_display'])) {
        $user_prefs['DOB_DISPLAY'] = trim(_stripslashes($_POST['dob_display']));
    }else {
        $user_prefs['DOB_DISPLAY'] = 0;
    }

    if (isset($_POST['dob_display_global'])) {
        $user_prefs_global['DOB_DISPLAY'] = ($_POST['dob_display_global'] == "Y") ? true : false;
    } else {
        $user_prefs_global['DOB_DISPLAY'] = false;
    }

    // User's UID for updating with.

    $uid = bh_session_get_value('UID');

    // Update USER_PREFS

    if (user_update_prefs($uid, $user_prefs, $user_prefs_global)) {

        header_redirect("./edit_email.php?webtag=$webtag&updated=true", $lang['preferencesupdated']);
        exit;

    }else {

        $error_msg_array[] = $lang['failedtoupdateuserdetails'];
        $valid = false;
    }
}

if (!isset($uid)) $uid = bh_session_get_value('UID');

// Get User Prefs
$user_prefs = user_get_prefs($uid);

// Check to see if we should show the set for all forums checkboxes

$show_set_all = (forums_get_available_count() > 1) ? true : false;

html_draw_top();

echo "<h1>{$lang['emailandprivacy']}</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

    html_display_error_array($error_msg_array, '600', 'left');

}else if (isset($_GET['updated'])) {

    html_display_success_msg($lang['preferencesupdated'], '600', 'left');
}

echo "<br />\n";
echo "<form name=\"prefs\" action=\"edit_email.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";

if ($show_set_all) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">{$lang['emailsettings']}</td>\n";
    echo "                  <td align=\"left\" class=\"subhead\" width=\"1%\">&nbsp;</td>\n";
    echo "                </tr>\n";

}else {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"4\">{$lang['emailsettings']}</td>\n";
    echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td align=\"left\" rowspan=\"6\" width=\"1%\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("allow_email", "Y", $lang['allowemails'], (isset($user_prefs['ALLOW_EMAIL']) && $user_prefs['ALLOW_EMAIL'] == "Y") ? true : false), "</td>\n";
echo "                  <td align=\"right\" nowrap=\"nowrap\">", ($show_set_all) ? form_checkbox("allow_email_global", "Y", '', (isset($user_prefs['ALLOW_EMAIL_GLOBAL']) ? $user_prefs['ALLOW_EMAIL_GLOBAL'] : false), "title=\"{$lang['setforallforums']}\"") : form_input_hidden("allow_email_global", 'Y'), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("allow_pm", "Y", $lang['allowpersonalmessages'], (isset($user_prefs['ALLOW_PM']) && $user_prefs['ALLOW_PM'] == "Y") ? true : false), "</td>\n";
echo "                  <td align=\"right\" nowrap=\"nowrap\">", ($show_set_all) ? form_checkbox("allow_pm_global", "Y", '', (isset($user_prefs['ALLOW_PM_GLOBAL']) ? $user_prefs['ALLOW_PM_GLOBAL'] : false), "title=\"{$lang['setforallforums']}\"") : form_input_hidden("allow_pm_global", 'Y'), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("email_notify", "Y", $lang['notifybyemail'], (isset($user_prefs['EMAIL_NOTIFY']) && $user_prefs['EMAIL_NOTIFY'] == "Y") ? true : false), "</td>\n";
echo "                  <td align=\"right\" nowrap=\"nowrap\">", ($show_set_all) ? form_checkbox("email_notify_global", "Y", '', (isset($user_prefs['EMAIL_NOTIFY_GLOBAL']) ? $user_prefs['EMAIL_NOTIFY_GLOBAL'] : false), "title=\"{$lang['setforallforums']}\"") : form_input_hidden("email_notify_global", 'Y'), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" nowrap=\"nowrap\">", form_checkbox("pm_notify_email", "Y", $lang['notifyofnewpmemail'], (isset($user_prefs['PM_NOTIFY_EMAIL']) && $user_prefs['PM_NOTIFY_EMAIL'] == "Y") ? true : false), "</td>\n";
echo "                  <td align=\"left\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\">&nbsp;</td>\n";
echo "                  <td align=\"left\">&nbsp;</td>\n";
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

if ($show_set_all) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">{$lang['birthdayanddateofbirth']}</td>\n";
    echo "                  <td align=\"left\" class=\"subhead\" width=\"1%\">&nbsp;</td>\n";
    echo "                </tr>\n";

}else {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"4\">{$lang['birthdayanddateofbirth']}</td>\n";
    echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td align=\"left\" rowspan=\"6\" width=\"1%\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"2\" nowrap=\"nowrap\">", form_radio("dob_display", 0, $lang['donotshowmyageordobtoothers'], ((isset($user_prefs['DOB_DISPLAY']) && $user_prefs['DOB_DISPLAY'] == USER_DOB_DISPLAY_NONE) || !isset($user_prefs['DOB_DISPLAY'])) ? true : false), "</td>\n";
echo "                  <td align=\"right\" nowrap=\"nowrap\">", ($show_set_all) ? form_checkbox("dob_display_global", "Y", '', (isset($user_prefs['DOB_DISPLAY_GLOBAL']) ? $user_prefs['DOB_DISPLAY_GLOBAL'] : false), "title=\"{$lang['setforallforums']}\"") : form_input_hidden("dob_display_global", 'Y'), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"2\" nowrap=\"nowrap\">", form_radio("dob_display", 1, $lang['showonlymyagetoothers'], (isset($user_prefs['DOB_DISPLAY']) && $user_prefs['DOB_DISPLAY'] == USER_DOB_DISPLAY_AGE) ? true : false), "</td>\n";
echo "                  <td align=\"left\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"2\" nowrap=\"nowrap\">", form_radio("dob_display", 3, $lang['showonlymydayandmonthofbirthytoothers'], (isset($user_prefs['DOB_DISPLAY']) && $user_prefs['DOB_DISPLAY'] == USER_DOB_DISPLAY_BOTH) ? true : false), "</td>\n";
echo "                  <td align=\"left\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"2\" nowrap=\"nowrap\">", form_radio("dob_display", 2, $lang['showmyageanddobtoothers'], (isset($user_prefs['DOB_DISPLAY']) && $user_prefs['DOB_DISPLAY'] == USER_DOB_DISPLAY_DATE) ? true : false), "</td>\n";
echo "                  <td align=\"left\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\">&nbsp;</td>\n";
echo "                  <td align=\"left\">&nbsp;</td>\n";
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

if ($show_set_all) {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"3\">{$lang['forumanonymity']}</td>\n";
    echo "                  <td align=\"left\" class=\"subhead\" width=\"1%\">&nbsp;</td>\n";
    echo "                </tr>\n";

}else {

    echo "                <tr>\n";
    echo "                  <td align=\"left\" class=\"subhead\" colspan=\"4\">{$lang['forumanonymity']}</td>\n";
    echo "                </tr>\n";
}

echo "                <tr>\n";
echo "                  <td align=\"left\" rowspan=\"5\" width=\"1%\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"2\" nowrap=\"nowrap\">", form_radio("anon_logon", USER_ANON_DISABLED, $lang['listmeontheactiveusersdisplay'], ((isset($user_prefs['ANON_LOGON']) && $user_prefs['ANON_LOGON'] == USER_ANON_DISABLED) || !isset($user_prefs['ANON_LOGON'])) ? true : false), "</td>\n";
echo "                  <td align=\"right\" nowrap=\"nowrap\">", ($show_set_all) ? form_checkbox("anon_logon_global", "Y", '', (isset($user_prefs['ANON_LOGON_GLOBAL']) ? $user_prefs['ANON_LOGON_GLOBAL'] : false), "title=\"{$lang['setforallforums']}\"") : form_input_hidden("anon_logon_global", 'Y'), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"2\" nowrap=\"nowrap\">", form_radio("anon_logon", USER_ANON_ENABLED, $lang['browseanonymously'], (isset($user_prefs['ANON_LOGON']) && $user_prefs['ANON_LOGON'] == USER_ANON_ENABLED) ? true : false), "</td>\n";
echo "                  <td align=\"left\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" colspan=\"2\" nowrap=\"nowrap\">", form_radio("anon_logon", USER_ANON_FRIENDS_ONLY, $lang['allowfriendstoseemeasonline'], (isset($user_prefs['ANON_LOGON']) && $user_prefs['ANON_LOGON'] == USER_ANON_FRIENDS_ONLY) ? true : false), "</td>\n";
echo "                  <td align=\"left\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"left\">&nbsp;</td>\n";
echo "                  <td align=\"left\">&nbsp;</td>\n";
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
echo "      <td align=\"center\">", form_submit("submit", $lang['save']), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";

html_draw_bottom();

?>