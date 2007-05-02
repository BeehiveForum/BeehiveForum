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

/* $Id: edit_password.php,v 1.55 2007-05-02 23:15:40 decoyduck Exp $ */

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

// Fetch the forum settings
$forum_settings = forum_get_settings();

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
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

if (bh_session_get_value('UID') == 0) {
    html_guest_error();
    exit;
}

if (isset($_POST['submit'])) {

    $valid = true;
    $error_html = "";

    // Required fields

    if (isset($_POST['opw']) && strlen(trim(_stripslashes($_POST['opw']))) > 0) {

        if (isset($_POST['npw']) && strlen(trim(_stripslashes($_POST['npw']))) > 0) {

            if (isset($_POST['cpw']) && strlen(trim(_stripslashes($_POST['cpw']))) > 0) {

                if (trim(_stripslashes($_POST['npw'])) == trim(_stripslashes($_POST['cpw']))) {

                    if (_htmlentities(trim(_stripslashes($_POST['npw']))) != trim(trim(_stripslashes($_POST['npw'])))) {
                        $error_html.= "<h2>{$lang['passwdmustnotcontainHTML']}</h2>\n";
                        $valid = false;
                    }

                    if (!preg_match("/^[a-z0-9_-]+$/i", trim(_stripslashes($_POST['npw'])))) {
                        $error_html.= "<h2>{$lang['passwordinvalidchars']}</h2>\n";
                        $valid = false;
                    }

                    if (strlen(trim(_stripslashes($_POST['npw']))) < 6) {
                        $error_html.= "<h2>{$lang['passwdtooshort']}</h2>\n";
                        $valid = false;
                    }

                    if ($valid) {
                        $t_password = trim(_stripslashes($_POST['npw']));
                        $t_passhash = md5(trim(_stripslashes($_POST['opw'])));
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
    }

    if ($valid) {

        // User's UID for updating with.

        $uid = bh_session_get_value('UID');

        // Update the password and cookie

        user_change_password($uid, $t_password, $t_passhash);

        // Retrieve existing cookie data if any

        logon_get_cookies($username_array, $password_array, $passhash_array);

        // Fetch current logon.

        $logon = bh_session_get_value('LOGON');

        // Update the password that matches the current logged on user

        logon_update_password_cookie($logon, $t_password);

        // Force redirect to prevent refreshing the page 
        // prompting to user to resubmit form data.

        header_redirect("./edit_password.php?webtag=$webtag&updated=true", $lang['passwdchanged']);
    }
}

// Start Output Here

html_draw_top();

echo "<h1>{$lang['changepassword']}</h1>\n";

// Any error messages to display?

if (!empty($error_html)) {
    echo $error_html;
}else if (isset($_GET['updated'])) {
    echo "<h2>{$lang['passwdchanged']}</h2>\n";
}

echo "<br />\n";
echo "<form name=\"prefs\" action=\"edit_password.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
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
echo "                        <td align=\"left\">", form_field("opw", "", 37, 0, "password"), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">{$lang['newpasswd']}:</td>\n";
echo "                        <td align=\"left\">", form_field("npw", "", 37, 0, "password"), "&nbsp;</td>\n";
echo "                      </tr>\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">{$lang['confirmpasswd']}:</td>\n";
echo "                        <td align=\"left\">", form_field("cpw", "", 37, 0, "password"), "&nbsp;</td>\n";
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
echo "      <td align=\"center\">", form_submit("submit", $lang['save']), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";

html_draw_bottom();

?>