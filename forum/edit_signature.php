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

/* $Id: edit_signature.php,v 1.1 2004-01-25 12:46:05 decoyduck Exp $ */

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

user_get_sig(bh_session_get_value('UID'), $user_sig['SIG_CONTENT'], $user_sig['SIG_HTML']);

// Split the DOB into usable variables.

if (isset($user_prefs['DOB']) && preg_match("/\d{4,}-\d{2,}-\d{2,}/", $user_prefs['DOB'])) {
    list($dob_year, $dob_month, $dob_day) = explode('-', $user_prefs['DOB']);
    $dob_blank_fields = ($dob_year == 0 || $dob_month == 0 || $dob_day == 0) ? true : false;
}else {
    $dob_year = 0;
    $dob_month = 0;
    $dob_day = 0;
    $dob_blank_fields = true;
}

// Start Output Here

html_draw_top();

echo "<h1>{$lang['signature']}</h1>\n";
echo "<br />\n";
echo "<div class=\"postbody\">\n";
echo "  <form name=\"prefs\" action=\"./edit_signature.php\" method=\"post\" target=\"_self\">\n";
echo "    <table cellpadding=\"0\" cellspacing=\"0\">\n";
echo "      <tr>\n";
echo "        <td>\n";
echo "          <table class=\"box\">\n";
echo "            <tr>\n";
echo "              <td class=\"posthead\">\n";
echo "                <table class=\"posthead\" width=\"100%\">\n";
echo "                  <tr>\n";
echo "                    <td class=\"subhead\">{$lang['signature']}</td>\n";
echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td>", form_textarea("sig_content", (isset($t_sig_content) ? _htmlentities(_stripslashes($t_sig_content)) : _htmlentities(_stripslashes($user_sig['SIG_CONTENT']))), 4, 60), "</td>\n";
echo "                  </tr>\n";
echo "                  <tr>\n";
echo "                    <td align=\"right\">", form_checkbox("sig_html", "Y", $lang['containsHTML'], (isset($t_sig_html) && $t_sig_html == "Y") ? true : ($user_sig['SIG_HTML'] == "Y")), "</td>\n";
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