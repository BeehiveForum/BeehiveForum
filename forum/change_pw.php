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

/* $Id: change_pw.php,v 1.49 2005-03-28 19:43:28 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "./include/");

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

// Load language file

$lang = load_language_file();

// Check we have a webtag

$webtag = get_webtag($webtag_search);

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

if (isset($_POST['submit'])) {

    $valid = true;
    $error_html = "";

    if (isset($_POST['uid']) && is_numeric($_POST['uid'])) {
        $uid = $_POST['uid'];
    }else {
        $error_html = "<h2>{$lang['allfieldsrequired']}</h2>";
        $valid = false;
    }

    if (isset($_POST['key']) && is_md5(trim(_stripslashes($_POST['key'])))) {
        $key = $_POST['key'];
    }else {
        $error_html = "<h2>{$lang['allfieldsrequired']}</h2>";
        $valid = false;
    }

    if (isset($_POST['pw']) && strlen(trim(_stripslashes($_POST['pw'])))) {
        $pw = $_POST['pw'];
    }else {
        $error_html = "<h2>{$lang['allfieldsrequired']}</h2>";
        $valid = false;
    }

    if (isset($_POST['cpw']) && strlen(trim(_stripslashes($_POST['cpw'])))) {
        $cpw = $_POST['cpw'];
    }else {
        $error_html = "<h2>{$lang['allfieldsrequired']}</h2>";
        $valid = false;
    }

    if ($valid) {

        if (_htmlentities($pw) != $pw) {
            $error_html.= "<h2>{$lang['passwdmustnotcontainHTML']}</h2>\n";
            $valid = false;
        }

        if (!preg_match("/^[a-z0-9_-]+$/i", trim(_stripslashes($_POST['pw'])))) {
            $error_html.= "<h2>{$lang['passwordinvalidchars']}</h2>\n";
            $valid = false;
        }

        if (strlen(trim(_stripslashes($_POST['pw']))) < 6) {
            $error_html.= "<h2>{$lang['passwdtooshort']}</h2>\n";
            $valid = false;
        }

        if ($pw != $cpw) {
            $error_html = "<h2>{$lang['passwdsdonotmatch']}</h2>";
            $valid = false;
        }
    }

    if ($valid) {

        if (user_change_pass($uid, $pw, $key)) {

            html_draw_top();

            echo "<h1>{$lang['passwdchanged']}</h1>";
            echo "<br />\n";
            echo "<div align=\"center\">\n";
            echo "<p>{$lang['passedchangedexp']}</p>\n";

            echo form_quick_button("./index.php", $lang['continue'], false, false, "_top");

            echo "</div>\n";

            html_draw_bottom();
            exit;

        }else {

            $error_html = "<h2>{$lang['updatefailed']}.</h2>";
            $valid = false;
        }
    }
}

if (isset($_GET['u']) && is_numeric($_GET['u']) && isset($_GET['h']) && is_md5($_GET['h'])) {
    $uid = $_GET['u'];
    $key = $_GET['h'];
}elseif (isset($_POST['uid']) && is_numeric($_POST['uid']) && isset($_POST['key']) && is_md5($_POST['key'])) {
    $uid = $_POST['uid'];
    $key = $_POST['key'];
}else {
    html_draw_top();
    echo "<h1>{$lang['error']}</h1>\n";
    echo "<h2>{$lang['requiredinformationnotfound']}</h2>\n";
    html_draw_bottom();
    exit;
}

if ($user = user_get_password($uid, $key)) {
    $logon = strtoupper($user['LOGON']);
}else {
    html_draw_top();
    echo "<h1>{$lang['error']}</h1>\n";
    echo "<h2>{$lang['requiredinformationnotfound']}</h2></div>\n";
    html_draw_bottom();
    exit;
}

html_draw_top();

echo "<h1>{$lang['forgotpasswd']}</h1>";

if (isset($error_html)) {
    echo $error_html;
}else {
    echo "<br />\n";
}

echo "<div align=\"center\">\n";
echo "  <p class=\"smalltext\">{$lang['enternewpasswdforuser']} $logon</p>\n";
echo "  <form name=\"forgot_pw\" action=\"change_pw.php\" method=\"post\">\n";
echo "  ", form_input_hidden('webtag', $webtag), "\n";
echo "  ", form_input_hidden("uid", $uid), "\n";
echo "  ", form_input_hidden("key", $key), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"300\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"box\">\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"300\">\n";
echo "                <tr>\n";
echo "                  <td colspan=\"2\" class=\"subhead\">{$lang['forgotpasswd']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"right\">{$lang['newpasswd']}:</td>\n";
echo "                  <td>", form_input_password("pw", ""), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"right\">{$lang['confirmpasswd']}:</td>\n";
echo "                  <td>", form_input_password("cpw", ""), "</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td>&nbsp;</td>\n";
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
echo "      <td align=\"center\">", form_submit("submit", $lang['submit']), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  </form>\n";
echo "</div>\n";

html_draw_bottom();

?>