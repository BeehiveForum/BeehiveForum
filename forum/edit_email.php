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

/* $Id: edit_email.php,v 1.8 2004-03-12 18:46:50 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

//Multiple forum support
include_once("./include/forum.inc.php");

include_once("./include/fixhtml.inc.php");
include_once("./include/form.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/post.inc.php");
include_once("./include/session.inc.php");
include_once("./include/user.inc.php");

if (!bh_session_check()) {

    $uri = "./logon.php?webtag=$webtag&final_uri=". urlencode(get_request_uri());
    header_redirect($uri);
}

if (bh_session_get_value('UID') == 0) {
    html_guest_error();
    exit;
}

if (isset($HTTP_POST_VARS['submit'])) {

    if (isset($HTTP_POST_VARS['email_notify']) && $HTTP_POST_VARS['email_notify'] == "Y") {
        $user_prefs['EMAIL_NOTIFY'] = "Y";
    }else {
        $user_prefs['EMAIL_NOTIFY'] = "";
    }

    if (isset($HTTP_POST_VARS['pm_notify_email']) && $HTTP_POST_VARS['pm_notify_email'] == "Y") {
        $user_prefs['PM_NOTIFY_EMAIL'] = "Y";
    }else {
        $user_prefs['PM_NOTIFY_EMAIL'] = "";
    }

    if (isset($HTTP_POST_VARS['anon_logon']) && $HTTP_POST_VARS['anon_logon'] == "Y") {
        $user_prefs['ANON_LOGON'] = 1;
    }else {
        $user_prefs['ANON_LOGON'] = 0;
    }

    if (isset($HTTP_POST_VARS['dob_display'])) {
        $user_prefs['DOB_DISPLAY'] = _stripslashes(trim($HTTP_POST_VARS['dob_display']));
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

    if (isset($HTTP_SERVER_VARS['SERVER_SOFTWARE']) && !strstr($HTTP_SERVER_VARS['SERVER_SOFTWARE'], 'Microsoft-IIS')) {

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

        form_quick_button("./edit_email.php?webtag=$webtag", $lang['continue'], "", "", "_top");

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
}else if (isset($HTTP_GET_VARS['updated'])) {
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
echo "                  <td>", form_checkbox("anon_logon", "Y", $lang['browseanonymously'], (isset($user_prefs['ANON_LOGON']) && $user_prefs['ANON_LOGON'] == 1) ? true : false), "</td>\n";
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