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

/* $Id: edit_email.php,v 1.25 2004-04-17 18:41:01 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Multiple forum support
include_once("./include/forum.inc.php");

// Fetch the forum settings
$forum_settings = get_forum_settings();

include_once("./include/fixhtml.inc.php");
include_once("./include/form.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/logon.inc.php");
include_once("./include/post.inc.php");
include_once("./include/session.inc.php");
include_once("./include/user.inc.php");

if (!$user_sess = bh_session_check()) {

    if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
        
        if (perform_logon(false)) {
	    
	    html_draw_top();

            echo "<h1>{$lang['loggedinsuccessfully']}</h1>";
            echo "<div align=\"center\">\n";
	    echo "<p><b>{$lang['presscontinuetoresend']}</b></p>\n";

            $request_uri = get_request_uri();

            echo "<form method=\"post\" action=\"$request_uri\" target=\"_self\">\n";

            foreach($_POST as $key => $value) {
	        form_input_hidden($key, _htmlentities(_stripslashes($value)));
            }

	    echo form_submit(md5(uniqid(rand())), $lang['continue']), "&nbsp;";
            echo form_button(md5(uniqid(rand())), $lang['cancel'], "onclick=\"self.location.href='$request_uri'\""), "\n";
	    echo "</form>\n";
	    
	    html_draw_bottom();
	    exit;
	}

    }else {
        html_draw_top();
        draw_logon_form(false);
	html_draw_bottom();
	exit;
    }
}

// Check we have a webtag

if (!$webtag = get_webtag()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?final_uri=$request_uri");
}

if (bh_session_get_value('UID') == 0) {
    html_guest_error();
    exit;
}

if (isset($_POST['submit'])) {

    if (isset($_POST['allow_email']) && $_POST['allow_email'] == "Y") {
        $user_prefs['ALLOW_EMAIL'] = "Y";
    }else {
        $user_prefs['ALLOW_EMAIL'] = "";
    }

    if (isset($_POST['allow_pm']) && $_POST['allow_pm'] == "Y") {
        $user_prefs['ALLOW_PM'] = "Y";
    }else {
        $user_prefs['ALLOW_PM'] = "";
    }

    if (isset($_POST['email_notify']) && $_POST['email_notify'] == "Y") {
        $user_prefs['EMAIL_NOTIFY'] = "Y";
    }else {
        $user_prefs['EMAIL_NOTIFY'] = "";
    }

    if (isset($_POST['pm_notify_email']) && $_POST['pm_notify_email'] == "Y") {
        $user_prefs['PM_NOTIFY_EMAIL'] = "Y";
    }else {
        $user_prefs['PM_NOTIFY_EMAIL'] = "";
    }

    if (isset($_POST['anon_logon']) && $_POST['anon_logon'] == "Y") {
        $user_prefs['ANON_LOGON'] = 1;
    }else {
        $user_prefs['ANON_LOGON'] = 0;
    }

    if (isset($_POST['dob_display'])) {
        $user_prefs['DOB_DISPLAY'] = _stripslashes(trim($_POST['dob_display']));
    }else {
        $user_prefs['DOB_DISPLAY'] = 0;
    }

    // User's UID for updating with.

    $uid = bh_session_get_value('UID');

    // Update USER_PREFS

    user_update_prefs($uid, $user_prefs);

    // Reinitialize the User's Session to save them having to logout and back in

    bh_session_init($uid);

    // IIS bug prevents redirect at same time as setting cookies.

    if (isset($_SERVER['SERVER_SOFTWARE']) && !strstr($_SERVER['SERVER_SOFTWARE'], 'Microsoft-IIS')) {

        header_redirect("./edit_email.php?webtag=$webtag&updated=true");

    }else {

        html_draw_top();

        // Try a Javascript redirect
        echo "<script language=\"javascript\" type=\"text/javascript\">\n";
        echo "<!--\n";
        echo "document.location.href = './edit_email.php?webtag=$webtag&updated=true';\n";
        echo "//-->\n";
        echo "</script>";

        // If they're still here, Javascript's not working. Give up, give a link.
        echo "<div align=\"center\"><p>&nbsp;</p><p>&nbsp;</p>";
        echo "<p>{$lang['preferencesupdated']}</p>";

        form_quick_button("./edit_email.php", $lang['continue'], false, false, "_top");

        html_draw_bottom();
        exit;
    }
}

// Get User Prefs

if (!isset($user_prefs) || !is_array($user_prefs)) $user_prefs = array();
$user_prefs = array_merge(user_get(bh_session_get_value('UID')), $user_prefs);
$user_prefs = array_merge(user_get_prefs(bh_session_get_value('UID')), $user_prefs);

// Start output here

html_draw_top();

echo "<h1>{$lang['emailandprivacy']}</h1>\n";

// Any error messages to display?

if (!empty($error_html)) {
    echo $error_html;
}else if (isset($_GET['updated'])) {
    echo "<h2>{$lang['preferencesupdated']}</h2>\n";
}

echo "<br />\n";
echo "<form name=\"prefs\" action=\"edit_email.php?webtag=$webtag\" method=\"post\" target=\"_self\">\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"400\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"400\">\n";
echo "                <tr>\n";
echo "                  <td colspan=\"2\" class=\"subhead\">{$lang['emailsettings']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td>", form_checkbox("email_notify", "Y", $lang['notifybyemail'], (isset($user_prefs['EMAIL_NOTIFY']) && $user_prefs['EMAIL_NOTIFY'] == "Y") ? true : false), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td>", form_checkbox("pm_notify_email", "Y", $lang['notifyofnewpmemail'], (isset($user_prefs['PM_NOTIFY_EMAIL']) && $user_prefs['PM_NOTIFY_EMAIL'] == "Y") ? true : false), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td>&nbsp;</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "            </td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  <br />\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"400\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"400\">\n";
echo "                <tr>\n";
echo "                  <td colspan=\"2\" class=\"subhead\">{$lang['privacysettings']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td>{$lang['ageanddob']}:</td>\n";

if (isset($user_prefs['DOB_DISPLAY'])) {
    echo "                    <td>", form_dropdown_array("dob_display", range(0, 2), array($lang['neitheragenordob'], $lang['showonlyage'], $lang['showageanddob']), $user_prefs['DOB_DISPLAY']), "</td>\n";
}else {
    echo "                    <td>", form_dropdown_array("dob_display", range(0, 2), array($lang['neitheragenordob'], $lang['showonlyage'], $lang['showageanddob']), 0), "</td>\n";
}

echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"2\">", form_checkbox("allow_email", "Y", $lang['allowemails'], (isset($user_prefs['ALLOW_EMAIL']) && $user_prefs['ALLOW_EMAIL'] == "Y") ? true : false), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"2\">", form_checkbox("allow_pm", "Y", $lang['allowpersonalmessages'], (isset($user_prefs['ALLOW_PM']) && $user_prefs['ALLOW_PM'] == "Y") ? true : false), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"2\">", form_checkbox("anon_logon", "Y", $lang['browseanonymously'], (isset($user_prefs['ANON_LOGON']) && $user_prefs['ANON_LOGON'] == 1) ? true : false), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td>&nbsp;</td>\n";
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

html_draw_bottom();

?>