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

/* $Id: edit_prefs.php,v 1.7 2004-03-11 22:34:36 decoyduck Exp $ */

//Multiple forum support
include_once("./include/forum.inc.php");

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

//Check logged in status
include_once("./include/session.inc.php");
include_once("./include/header.inc.php");

if(!bh_session_check()){

    $uri = "./logon.php?webtag=$webtag&final_uri=". urlencode(get_request_uri());
    header_redirect($uri);
}

if (bh_session_get_value('UID') == 0) {
    html_guest_error();
    exit;
}

include_once("./include/html.inc.php");
include_once("./include/user.inc.php");
include_once("./include/post.inc.php");
include_once("./include/fixhtml.inc.php");
include_once("./include/form.inc.php");
include_once("./include/header.inc.php");
include_once("./include/lang.inc.php");

$error_html = "";

if (isset($HTTP_POST_VARS['submit'])) {

    $valid = true;
    
    // Required Fields

    if (isset($HTTP_POST_VARS['nickname']) && trim($HTTP_POST_VARS['nickname']) != "") {
        $user_prefs['NICKNAME'] = _stripslashes(trim($HTTP_POST_VARS['nickname']));       
    }else {
        $error_html.= "<h2>{$lang['nicknamerequired']}</h2>";
        $valid = false;
    }

    if (isset($HTTP_POST_VARS['email']) && trim($HTTP_POST_VARS['email']) != "") {
        $user_prefs['EMAIL'] = _stripslashes(trim($HTTP_POST_VARS['email']));      
    }else {
        $error_html.= "<h2>{$lang['emailaddressrequired']}</h2>";
        $valid = false;
    }

    if (isset($HTTP_POST_VARS['dob_year']) && isset($HTTP_POST_VARS['dob_month']) && isset($HTTP_POST_VARS['dob_day']) && checkdate($HTTP_POST_VARS['dob_month'], $HTTP_POST_VARS['dob_day'], $HTTP_POST_VARS['dob_year'])) {

        $user_prefs['DOB_DAY']   = _stripslashes(trim($HTTP_POST_VARS['dob_day']));
        $user_prefs['DOB_MONTH'] = _stripslashes(trim($HTTP_POST_VARS['dob_month']));
        $user_prefs['DOB_YEAR']  = _stripslashes(trim($HTTP_POST_VARS['dob_year']));
        
        $user_prefs['DOB'] = "{$user_prefs['DOB_YEAR']}-{$user_prefs['DOB_MONTH']}-{$user_prefs['DOB_DAY']}";
        $user_prefs['DOB_BLANK_FIELDS'] = ($user_prefs['DOB_YEAR'] == 0 || $user_prefs['DOB_MONTH'] == 0 || $user_prefs['DOB_DAY'] == 0) ? true : false;
        
    }else {
        $error_html.= "<h2>{$lang['birthdayrequired']}</h2>";
        $valid = false;
    }

    // Optional fields

    if (isset($HTTP_POST_VARS['firstname']) && trim($HTTP_POST_VARS['firstname']) != "") {
        $user_prefs['FIRSTNAME'] = _stripslashes(trim($HTTP_POST_VARS['firstname']));       
    }else {
        $user_prefs['FIRSTNAME'] = "";
    }

    if (isset($HTTP_POST_VARS['lastname']) && trim($HTTP_POST_VARS['lastname']) != "") {
        $user_prefs['LASTNAME'] = _stripslashes(trim($HTTP_POST_VARS['lastname']));
    }else {
        $user_prefs['LASTNAME'] = "";
    }

    if (isset($HTTP_POST_VARS['homepage_url']) && trim($HTTP_POST_VARS['homepage_url']) != "") {
        $user_prefs['HOMEPAGE_URL'] = _stripslashes(trim($HTTP_POST_VARS['homepage_url']));
    }else {
        $user_prefs['HOMEPAGE_URL'] = "";
    }

    if (isset($HTTP_POST_VARS['pic_url']) && trim($HTTP_POST_VARS['pic_url']) != "") {
        $user_prefs['PIC_URL'] = _stripslashes(trim($HTTP_POST_VARS['pic_url']));
    }else {
        $user_prefs['PIC_URL'] = "";
    }

    if ($valid) {

        // User's UID for updating with.

        $uid = bh_session_get_value('UID');

        // Update basic settings in USER table

        user_update($uid, $user_prefs['NICKNAME'], $user_prefs['EMAIL']);

        // Update USER_PREFS

        user_update_prefs($uid, $user_prefs);

        // Reinitialize the User's Session to save them having to logout and back in

        bh_session_init($uid);

        // IIS bug prevents redirect at same time as setting cookies.

        if (isset($HTTP_SERVER_VARS['SERVER_SOFTWARE']) && !strstr($HTTP_SERVER_VARS['SERVER_SOFTWARE'], 'Microsoft-IIS')) {

            header_redirect("./edit_prefs.php?webtag=$webtag&updated=true");

        }else {

            html_draw_top();

            // Try a Javascript redirect
            echo "<script language=\"javascript\" type=\"text/javascript\">\n";
            echo "<!--\n";
            echo "document.location.href = './edit_prefs.php?webtag=$webtag&updated=true';\n";
            echo "//-->\n";
            echo "</script>";

            // If they're still here, Javascript's not working. Give up, give a link.
            echo "<div align=\"center\"><p>&nbsp;</p><p>&nbsp;</p>";
            echo "<p>{$lang['preferencesupdated']}</p>";

            form_quick_button("./edit_prefs.php?webtag=$webtag", $lang['continue'], "", "", "_top");

            html_draw_bottom();
            exit;
        }
    }
}

// Get User Prefs

if (!isset($user_prefs) || !is_array($user_prefs)) $user_prefs = array();
$user_prefs = array_merge(user_get(bh_session_get_value('UID')), $user_prefs);
$user_prefs = array_merge(user_get_prefs(bh_session_get_value('UID')), $user_prefs);

// Split the DOB into usable variables.

if (isset($user_prefs['DOB']) && preg_match("/\d{4,}-\d{2,}-\d{2,}/", $user_prefs['DOB'])) {
    list($user_prefs['DOB_YEAR'], $user_prefs['DOB_MONTH'], $user_prefs['DOB_DAY']) = explode('-', $user_prefs['DOB']);
    $user_prefs['DOB_BLANK_FIELDS'] = ($user_prefs['DOB_YEAR'] == 0 || $user_prefs['DOB_MONTH'] == 0 || $user_prefs['DOB_DAY'] == 0) ? true : false;
}else {
    $user_prefs['DOB_YEAR']  = 0;
    $user_prefs['DOB_MONTH'] = 0;
    $user_prefs['DOB_DAY']   = 0;
    $user_prefs['DOB_BLANK_FIELDS'] = true;
}

// Start Output Here

html_draw_top();

echo "<h1>{$lang['userdetails']}</h1>\n";

// Any error messages to display?

if (!empty($error_html)) {
    echo $error_html;
}else if (isset($HTTP_GET_VARS['updated'])) {
    echo "<h2>{$lang['preferencesupdated']}</h2>\n";
}

echo "<br />\n";
echo "<form name=\"prefs\" action=\"edit_prefs.php?webtag=$webtag\" method=\"post\" target=\"_self\">\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" colspan=\"2\">{$lang['userinformation']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"200\">{$lang['nickname']}:</td>\n";
echo "                  <td>", form_field("nickname", (isset($user_prefs['NICKNAME']) ? $user_prefs['NICKNAME'] : ""), 45, 32), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"200\">{$lang['emailaddress']}:</td>\n";
echo "                  <td>", form_field("email", (isset($user_prefs['EMAIL']) ? $user_prefs['EMAIL'] : ""), 45, 80), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"2\">&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"200\">{$lang['firstname']}:</td>\n";
echo "                  <td>", form_field("firstname", (isset($user_prefs['FIRSTNAME']) ? $user_prefs['FIRSTNAME'] : ""), 45, 32), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"200\">{$lang['lastname']}:</td>\n";
echo "                  <td>", form_field("lastname", (isset($user_prefs['LASTNAME']) ? $user_prefs['LASTNAME'] : ""), 45, 32), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td>{$lang['dateofbirth']}:</td>\n";
echo "                  <td>", form_dob_dropdowns($user_prefs['DOB_YEAR'], $user_prefs['DOB_MONTH'], $user_prefs['DOB_DAY'], $user_prefs['DOB_BLANK_FIELDS']), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"200\">{$lang['homepageURL']}:</td>\n";
echo "                  <td>", form_field("homepage_url", (isset($user_prefs['HOMEPAGE_URL']) ? $user_prefs['HOMEPAGE_URL'] : ""), 45, 255), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td width=\"200\">{$lang['pictureURL']}:</td>\n";
echo "                  <td>", form_field("pic_url", (isset($user_prefs['PIC_URL']) ? $user_prefs['PIC_URL'] : ""), 45, 255), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td colspan=\"2\">&nbsp;</td>\n";
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