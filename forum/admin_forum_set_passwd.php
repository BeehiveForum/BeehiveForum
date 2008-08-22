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

/* $Id: admin_forum_set_passwd.php,v 1.35 2008-08-22 19:07:19 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

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

include_once(BH_INCLUDE_PATH. "admin.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "folder.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "perm.inc.php");
include_once(BH_INCLUDE_PATH. "post.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");

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

// Check we have a webtag

if (!forum_check_webtag_available($webtag)) {
    $request_uri = rawurlencode(get_request_uri(false));
    header_redirect("forums.php?webtag_error&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

if (!(bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0))) {

    html_draw_top();
    html_error_msg($lang['accessdeniedexp']);
    html_draw_bottom();
    exit;
}

if (isset($_POST['ret']) && strlen(trim(_stripslashes($_POST['ret']))) > 0) {
    $ret = trim(_stripslashes($_POST['ret']));
}elseif (isset($_GET['ret']) && strlen(trim(_stripslashes($_GET['ret']))) > 0) {
    $ret = trim(_stripslashes($_GET['ret']));
}else {
    $ret = "admin_forums.php?webtag=$webtag";
}

// Array to hold error messages

$error_msg_array = array();

// validate the return to page

if (isset($ret) && strlen(trim($ret)) > 0) {

    $available_files = get_available_files();
    $available_files_preg = implode("|^", array_map('preg_quote_callback', $available_files));

    if (preg_match("/^$available_files_preg/u", basename($ret)) < 1) {
        $ret = "admin_forums.php?webtag=$webtag";
    }
}

if (isset($_POST['back'])) {
    header_redirect($ret);
}

if (!forum_get_setting('access_level', 2, false)) {

    html_draw_top();
    html_error_msg($lang['forumisnotrestricted'], 'admin_forum_set_passwd.php', 'post', array('back' => $lang['back']), array('ret' => $ret));
    html_draw_bottom();
    exit;
}

if (!$fid = forum_get_setting('fid')) {

    html_draw_top();
    html_error_msg($lang['accessdeniedexp']);
    html_draw_bottom();
    exit;
}

if (isset($_POST['save'])) {

    $valid = true;

    if (isset($_POST['pw']) && strlen(trim(_stripslashes($_POST['pw']))) > 0) {
        $t_password = trim(_stripslashes($_POST['pw']));
    }else {
        $error_msg_array[] = $lang['passwdrequired'];
        $valid = false;
    }

    if (isset($_POST['cpw']) && strlen(trim(_stripslashes($_POST['cpw']))) > 0) {
        $t_check_password = trim(_stripslashes($_POST['cpw']));
    }else {
        $valid = false;
    }

    if ($valid) {

        if ($t_password != $t_check_password) {

            $error_msg_array[] = $lang['passwdsdonotmatch'];
            $valid = false;
        }

        if (_htmlentities($t_password) != $t_password) {

            $error_msg_array[] = $lang['passwdmustnotcontainHTML'];
            $valid = false;
        }

        if (!preg_match("/^[a-z0-9_-]+$/iu", $t_password)) {

            $error_msg_array[] = $lang['passwordinvalidchars'];
            $valid = false;
        }

        if (strlen($t_password) < 6) {

            $error_msg_array[] = $lang['passwdtooshort'];
            $valid = false;
        }

        if ($valid) {

            if (forum_update_password($fid, $t_password)) {

                header_redirect("admin_forum_set_passwd.php?webtag=$webtag&ret=$ret&updated=true");
                exit;
            }
        }
    }
}

html_draw_top();

echo "<h1>{$lang['admin']} &raquo; ", forum_get_setting('forum_name', false, 'A Beehive Forum'), " &raquo; {$lang['changepassword']}</h1>\n";

if (isset($error_msg_array) && sizeof($error_msg_array) > 0) {

    html_display_error_array($error_msg_array, '450', 'center');

}else if (isset($_GET['updated'])) {

    html_display_success_msg($lang['passwdchanged'], '450', 'center');
}

echo "<br />\n";
echo "<div align=\"center\">\n";
echo "<form accept-charset=\"utf-8\" name=\"passwd\" action=\"admin_forum_set_passwd.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', _htmlentities($webtag)), "\n";
echo "  ", form_input_hidden('ret', _htmlentities($ret)), "\n";
echo "  <table cellpadding=\"0\" cellspacing=\"0\" width=\"450\">\n";
echo "    <tr>\n";
echo "      <td align=\"left\">\n";
echo "        <table class=\"box\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td align=\"left\" class=\"posthead\">\n";
echo "              <table class=\"posthead\" width=\"100%\">\n";
echo "                <tr>\n";
echo "                  <td align=\"left\" class=\"subhead\">{$lang['changepassword']}</td>\n";
echo "                </tr>\n";
echo "                <tr>\n";
echo "                  <td align=\"center\">\n";
echo "                    <table class=\"posthead\" width=\"95%\">\n";
echo "                      <tr>\n";
echo "                        <td align=\"left\">{$lang['newpasswd']}:</td>\n";
echo "                        <td align=\"left\">", form_input_password("pw", "", 37, 0), "&nbsp;</td>\n";
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
echo "      <td align=\"center\">", form_submit("save", $lang['save']), "&nbsp;", form_submit("back", $lang['back']), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";
echo "</div>\n";

html_draw_bottom();

?>