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

/* $Id: edit_email.php,v 1.1 2004-01-24 16:42:45 decoyduck Exp $ */

// Compress the output
require_once("./include/gzipenc.inc.php");

// Enable the error handler
require_once("./include/errorhandler.inc.php");

//Check logged in status
require_once("./include/session.inc.php");
require_once("./include/header.inc.php");

if(!bh_session_check()){

    $uri = "./logon.php?final_uri=". urlencode(get_request_uri());
    header_redirect($uri);

}

require_once("./include/html.inc.php");
require_once("./include/user.inc.php");
require_once("./include/post.inc.php");
require_once("./include/fixhtml.inc.php");
require_once("./include/form.inc.php");
require_once("./include/header.inc.php");
require_once("./include/lang.inc.php");

// Get User Prefs

$user = user_get(bh_session_get_value('UID'));
$user_prefs = user_get_prefs(bh_session_get_value('UID'));

// Start output here

html_draw_top();

echo "<h1>{$lang['emailandprivacy']}</h1>\n";
echo "<br />\n";
echo "<div class=\"postbody\">\n";
echo "  <form name=\"prefs\" action=\"./prefs.php\" method=\"post\" target=\"_self\">\n";
echo "    <table cellpadding=\"0\" cellspacing=\"0\" width=\"400\">\n";
echo "      <tr>\n";
echo "        <td>\n";
echo "          <table class=\"box\">\n";
echo "            <tr>\n";
echo "              <td class=\"posthead\">\n";
echo "                <table class=\"posthead\" width=\"400\">\n";
echo "                  <tr>\n";
echo "                    <td colspan=\"2\" class=\"subhead\">Email Settings</td>\n";
echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td>", form_checkbox("email_notify", "Y", $lang['notifybyemail'], (isset($t_email_notify) && $t_email_notify == "Y") ? true : (isset($user_prefs['EMAIL_NOTIFY']) && $user_prefs['EMAIL_NOTIFY'] == "Y")), "</td>\n";
echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td>", form_checkbox("pm_notify_email", "Y", $lang['notifyofnewpmemail'], (isset($t_pm_notify_email) && $t_pm_notify_email == "Y") ? true : (isset($user_prefs['PM_NOTIFY_EMAIL']) && $user_prefs['PM_NOTIFY_EMAIL'] == "Y")), "</td>\n";
echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td>&nbsp;</td>\n";
echo "                  </tr>\n";
echo "                </table>\n";
echo "              </td>\n";
echo "            </tr>\n";
echo "          </table>\n";
echo "        </td>\n";
echo "      </tr>\n";
echo "    </table>\n";
echo "    <br />\n";
echo "    <table cellpadding=\"0\" cellspacing=\"0\" width=\"400\">\n";
echo "      <tr>\n";
echo "        <td>\n";
echo "          <table class=\"box\">\n";
echo "            <tr>\n";
echo "              <td class=\"posthead\">\n";
echo "                <table class=\"posthead\" width=\"400\">\n";
echo "                  <tr>\n";
echo "                    <td colspan=\"2\" class=\"subhead\">Privacy Settings</td>\n";
echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td>{$lang['ageanddob']}</td>\n";

if (isset($t_dob_display)) {
    echo "                    <td>", form_dropdown_array("dob_display", range(0, 2), array($lang['neitheragenordob'], $lang['showonlyage'], $lang['showageanddob']), $t_dob_display), "</td>\n";
}elseif (isset($user_prefs['DOB_DISPLAY'])) {
    echo "                    <td>", form_dropdown_array("dob_display", range(0, 2), array($lang['neitheragenordob'], $lang['showonlyage'], $lang['showageanddob']), $user_prefs['DOB_DISPLAY']), "</td>\n";
}else {
    echo "                    <td>", form_dropdown_array("dob_display", range(0, 2), array($lang['neitheragenordob'], $lang['showonlyage'], $lang['showageanddob']), 0), "</td>\n";
}

echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td>", form_checkbox("anon_logon", "Y", $lang['browseanonymously'], (isset($t_anon_logon) && $t_anon_logon == 1) ? true : (isset($user_prefs['ANON_LOGON']) && $user_prefs['ANON_LOGON'] == 1)), "</td>\n";
echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td>&nbsp;</td>\n";
echo "                  </tr>\n";
echo "                </table>\n";
echo "              </td>\n";
echo "            </tr>\n";
echo "          </table>\n";
echo "        </td>\n";
echo "      </tr>\n";
echo "      <tr>\n";
echo "        <td align=\"center\"><p>", form_submit("submit", $lang['save']), "</p></td>\n";
echo "      </tr>\n";
echo "    </table>\n";
echo "  </form>\n";
echo "</div>\n";

html_draw_bottom();

?>