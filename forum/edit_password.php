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

/* $Id: edit_password.php,v 1.10 2004-03-14 18:33:41 decoyduck Exp $ */

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

if (!$user_sess = bh_session_check()) {

    $uri = "./logon.php?webtag={$webtag['WEBTAG']}&final_uri=". rawurlencode(get_request_uri());
    header_redirect($uri);
}

// Load the wordfilter for the current user

$user_wordfilter = load_wordfilter();

if (bh_session_get_value('UID') == 0) {
    html_guest_error();
    exit;
}

if (isset($HTTP_POST_VARS['submit'])) {

    $valid = true;
    $error_html = "";

    // Required fields

    if (isset($HTTP_POST_VARS['pw']) && strlen(trim($HTTP_POST_VARS['pw'])) > 0) {
    
        if (isset($HTTP_POST_VARS['cpw']) && strlen(trim($HTTP_POST_VARS['cpw'])) > 0) {
        
            if (trim($HTTP_POST_VARS['pw']) == trim($HTTP_POST_VARS['cpw'])) {
            
                if (_htmlentities(trim($HTTP_POST_VARS['pw'])) != trim($HTTP_POST_VARS['pw'])) {
                    $error_html.= "<h2>{$lang['passwdmustnotcontainHTML']}</h2>\n";
                    $valid = false;
                }
                
                if (!preg_match("/^[a-z0-9_-]+$/i", trim($HTTP_POST_VARS['pw']))) {
                    $error_html.= "<h2>{$lang['passwordinvalidchars']}</h2>\n";
                    $valid = false;
                }                
                
                if (strlen(trim($HTTP_POST_VARS['pw'])) < 6) {
                    $error_html.= "<h2>{$lang['passwdtooshort']}</h2>\n";
                    $valid = false;
                }
                
                if ($valid) {
                    $t_password = $HTTP_POST_VARS['pw'];
                }
                
            }else {
                $error_html.= "<h2>{$lang['passwdsdonotmatch']}</h2>\n";
                $valid = false;
            }
            
        }else {
            $error_html.= "<h2>{$lang['passwdrequired']}</h2>\n";
            $valid = false;
        }

    }else {
        $error_html.= "<h2>{$lang['passwdrequired']}</h2>\n";
        $valid = false;
    }
    
    if ($valid) {

        // User's UID for updating with.

        $uid = bh_session_get_value('UID');

        // Update the password (and cookie)

        user_change_pw($uid, $t_password);

        // Username array

        if (isset($HTTP_COOKIE_VARS['bh_remember_username']) && is_array($HTTP_COOKIE_VARS['bh_remember_username'])) {
            $username_array = $HTTP_COOKIE_VARS['bh_remember_username'];
        }else {
            $username_array = array();
        }

        // Password array

        if (isset($HTTP_COOKIE_VARS['bh_remember_password']) && is_array($HTTP_COOKIE_VARS['bh_remember_password'])) {
            $password_array = $HTTP_COOKIE_VARS['bh_remember_password'];
        }else {
            $password_array = array();
        }

        // Passhash array

        if (isset($HTTP_COOKIE_VARS['bh_remember_passhash']) && is_array($HTTP_COOKIE_VARS['bh_remember_passhash'])) {
            $passhash_array = $HTTP_COOKIE_VARS['bh_remember_passhash'];
        }else {
            $passhash_array = array();
        }

        // Update the password that matches the current logged on user

        foreach ($username_array as $key => $logon) {
            if (stristr($logon, bh_session_get_value('LOGON'))) {
                $passw = str_repeat(chr(32), strlen(_stripslashes($t_password)));
                $passh = md5(_stripslashes($t_password));
                if (isset($password_array[$key]) && isset($passhash_array[$key])) {
                    bh_setcookie("bh_remember_password[$key]", $passw, time() + YEAR_IN_SECONDS);
                    bh_setcookie("bh_remember_passhash[$key]", $passh, time() + YEAR_IN_SECONDS);
                }
            }
        }

        // Reinitialize the User's Session otherwise they will get logged out when their
        // password check fails on the next page load.

        bh_session_init($uid);

        // IIS bug prevents redirect at same time as setting cookies.

        if (isset($HTTP_SERVER_VARS['SERVER_SOFTWARE']) && !strstr($HTTP_SERVER_VARS['SERVER_SOFTWARE'], 'Microsoft-IIS')) {

            header_redirect("./edit_password.php?webtag={$webtag['WEBTAG']}&updated=true");

        }else {

            html_draw_top();

            // Try a Javascript redirect
            echo "<script language=\"javascript\" type=\"text/javascript\">\n";
            echo "<!--\n";
            echo "document.location.href = './edit_password.php?webtag={$webtag['WEBTAG']}&updated=true';\n";
            echo "//-->\n";
            echo "</script>";

            // If they're still here, Javascript's not working. Give up, give a link.
            echo "<div align=\"center\"><p>&nbsp;</p><p>&nbsp;</p>";
            echo "<p>{$lang['userpreferences']}</p>";

            form_quick_button("./edit_password.php?webtag={$webtag['WEBTAG']}", $lang['continue'], "", "", "_top");

            html_draw_bottom();
            exit;
        }
    }
}    

// Start Output Here

html_draw_top();

echo "<h1>{$lang['changepassword']}</h1>\n";

// Any error messages to display?

if (!empty($error_html)) {
    echo $error_html;
}else if (isset($HTTP_GET_VARS['updated'])) {
    echo "<h2>{$lang['passwdchanged']}</h2>\n";
}

echo "<br />\n";
echo "<form name=\"prefs\" action=\"edit_password.php?webtag={$webtag['WEBTAG']}\" method=\"post\" target=\"_self\">\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td class=\"subhead\" colspan=\"2\">{$lang['changepassword']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td>{$lang['newpasswd']}:</td>\n";
echo "                  <td>", form_field("pw", "", 37, 0, "password"), "&nbsp;</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td>{$lang['confirmpasswd']}:</td>\n";
echo "                  <td>", form_field("cpw", "", 37, 0, "password"), "&nbsp;</td>\n";
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