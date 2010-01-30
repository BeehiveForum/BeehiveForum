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

/* $Id: edit_password.php,v 1.89 2010/01/29 20:54:27 decoyduck Exp $ */

// Set the default timezone
date_default_timezone_set('UTC');

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Disable PHP's register_globals
unregister_globals();

// Disable caching if on AOL
cache_disable_aol();

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

// Array to hold error messages

$error_msg_array = array();

// Arrays to hold our cookie data

$username_array = array();
$password_array = array();
$passhash_array = array();

// Submit code

if (isset($_POST['save'])) {

    $valid = true;

    if (isset($_POST['opw']) && strlen(trim(stripslashes_array($_POST['opw']))) > 0) {

        $t_old_pass = trim(stripslashes_array($_POST['opw']));

    }else {

        $error_msg_array[] = $lang['youmustenteryourcurrentpasswd'];
        $valid = false;
    }

    if (isset($_POST['npw']) && strlen(trim(stripslashes_array($_POST['npw']))) > 0) {

        $t_new_pass = trim(stripslashes_array($_POST['npw']));

    }else {

        $error_msg_array[] = $lang['youmustenteranewpasswd'];
        $valid = false;
    }

    if (isset($_POST['cpw']) && strlen(trim(stripslashes_array($_POST['cpw']))) > 0) {

        $t_confirm_pass = trim(stripslashes_array($_POST['cpw']));

    }else {

        $error_msg_array[] = $lang['youmustconfirmyournewpasswd'];
        $valid = false;
    }

    if ($valid) {

        if ($t_new_pass != $t_confirm_pass) {

            $error_msg_array[] = $lang['passwdsdonotmatch'];
            $valid = false;
        }

        if (htmlentities_array($t_new_pass) != $t_new_pass) {

            $error_msg_array[] = $lang['passwdmustnotcontainHTML'];
            $valid = false;
        }

        if (mb_strlen($t_new_pass) < 6) {

            $error_msg_array[] = $lang['passwdtooshort'];
            $valid = false;
        }

        if ($t_old_pass == $t_new_pass) {

            $error_msg_array[] = $lang['newandoldpasswdarethesame'];
            $valid = false;
        }

        if ($valid) {

            // User's UID for updating with.

            $uid = bh_session_get_value('UID');

            // Fetch current logon.

            $logon = bh_session_get_value('LOGON');

            // Generate MD5 hash of the old password

            $t_old_pass_hash = md5($t_old_pass);

            // Update the password and cookie

            if (user_change_password($uid, $t_new_pass, $t_old_pass_hash)) {

                // Update the password that matches the current logged on user

                logon_update_password_cookie($logon, $t_new_pass);

                // Force redirect to prevent refreshing the page
                // prompting to user to resubmit form data.

                header_redirect("edit_password.php?webtag=$webtag&updated=true", $lang['passwdchanged']);
                exit;

            }else {

                $error_msg_array[] = $lang['updatefailed'];
                $valid = false;
            }
        }
    }
}

// Start Output Here

html_draw_top("title={$lang['mycontrols']} » {$lang['changepassword']}");

echo "<h1>{$lang['changepassword']}</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

    html_display_error_array($error_msg_array, '600', 'left');

}else if (isset($_GET['updated'])) {

    html_display_success_msg($lang['preferencesupdated'], '600', 'left');
}

echo "<br />\n";
echo "<form accept-charset=\"utf-8\" name=\"prefs\" action=\"edit_password.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\" colspan=\"2\">{$lang['changepassword']}</td>\n";
echo "                </tr>\n";
echo "              </table>\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">{$lang['currentpasswd']}:</td>\n";
echo "                        <td align=\"left\">", form_input_password("opw", "", 37, 0), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">{$lang['newpasswd']}:</td>\n";
echo "                        <td align=\"left\">", form_input_password("npw", "", 37, 0), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">{$lang['confirmpasswd']}:</td>\n";
echo "                        <td align=\"left\">", form_input_password("cpw", "", 37, 0), "&nbsp;</td>\n";
echo "                      </tr>\n";
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