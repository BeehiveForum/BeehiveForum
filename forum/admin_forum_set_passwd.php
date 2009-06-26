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

/* $Id: admin_forum_set_passwd.php,v 1.46 2009-06-26 17:14:19 decoyduck Exp $ */

// Set the default timezone
date_default_timezone_set('UTC');

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Disable PHP's register_globals
unregister_globals();

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
include_once(BH_INCLUDE_PATH. "compat.inc.php");
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

$lang = lang::get_instance()->load(__FILE__);

if (!(bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0)) || (forum_get_setting('access_level', false, 0) == FORUM_DISABLED)) {

    html_draw_top();
    html_error_msg($lang['accessdeniedexp']);
    html_draw_bottom();
    exit;
}

if (!$forum_fid = forum_get_setting('fid')) {

    html_draw_top();
    html_error_msg($lang['accessdeniedexp']);
    html_draw_bottom();
    exit;
}

if (isset($_GET['ret']) && strlen(trim(stripslashes_array($_GET['ret']))) > 0) {
    $ret = rawurldecode(trim(stripslashes_array($_GET['ret'])));
}elseif (isset($_POST['ret']) && strlen(trim(stripslashes_array($_POST['ret']))) > 0) {
    $ret = trim(stripslashes_array($_POST['ret']));
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

if (isset($_POST['enable'])) {

    if (forum_update_access($forum_fid, FORUM_PASSWD_PROTECTED)) {

        header_redirect("admin_forum_set_passwd.php?webtag=$webtag");
        exit;
    }
}

if (!forum_get_setting('access_level', 2, false)) {

    html_draw_top();
    html_error_msg($lang['forumisnotsettopasswordprotectedmode'], 'admin_forum_set_passwd.php', 'post', array('enable' => $lang['enable'], 'back' => $lang['back']), array('ret' => $ret), false, 'center');
    html_draw_bottom();
    exit;
}

if (isset($_POST['save'])) {

    $valid = true;

    if (($forum_passhash = forum_get_password($forum_settings['fid']))) {

        if (isset($_POST['current_passwd']) && strlen(trim(stripslashes_array($_POST['current_passwd']))) > 0) {
            $t_current_passhash = md5(trim(stripslashes_array($_POST['current_passwd'])));
        }else {
            $error_msg_array[] = $lang['currentpasswdrequired'];
            $valid = false;
        }

        if ($valid) {

            if (strcmp($t_current_passhash, $forum_passhash) <> 0) {

                $error_msg_array[] = $lang['currentpasswddoesnotmatch'];
                $valid = false;
            }
        }
    }

    if (isset($_POST['new_passwd']) && strlen(trim(stripslashes_array($_POST['new_passwd']))) > 0) {
        $t_new_passwd = trim(stripslashes_array($_POST['new_passwd']));
    }else {
        $error_msg_array[] = $lang['newpasswdrequired'];
        $valid = false;
    }

    if (isset($_POST['confirm_passwd']) && strlen(trim(stripslashes_array($_POST['confirm_passwd']))) > 0) {
        $t_confirm_passwd = trim(stripslashes_array($_POST['confirm_passwd']));
    }else {
        $error_msg_array[] = $lang['confirmpasswordrequired'];
        $valid = false;
    }

    if ($valid) {

        if (strcmp($t_new_passwd, $t_confirm_passwd) <> 0) {

            $error_msg_array[] = $lang['passwdsdonotmatch'];
            $valid = false;
        }

        if (mb_strlen($t_new_passwd) < 6) {

            $error_msg_array[] = $lang['passwdtooshort'];
            $valid = false;
        }

        if (htmlentities_array($t_new_passwd) != $t_new_passwd) {

            $error_msg_array[] = $lang['passwdmustnotcontainHTML'];
            $valid = false;
        }

        if ($valid) {

            if (forum_update_password($forum_fid, $t_new_passwd)) {

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
echo "  ", form_input_hidden('webtag', htmlentities_array($webtag)), "\n";
echo "  ", form_input_hidden('ret', htmlentities_array($ret)), "\n";
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

if (forum_get_password($forum_settings['fid'])) {

    echo "                      <tr>\n";
    echo "                        <td align=\"left\">{$lang['currentpasswd']}:</td>\n";
    echo "                        <td align=\"left\">", form_input_password("current_passwd", "", 37, 0, "autocomplete=\"off\""), "&nbsp;</td>\n";
    echo "                      </tr>\n";
    echo "                      <tr>\n";
    echo "                        <td align=\"left\">{$lang['newpasswd']}:</td>\n";
    echo "                        <td align=\"left\">", form_input_password("new_passwd", "", 37, 0, "autocomplete=\"off\""), "&nbsp;</td>\n";
    echo "                      </tr>\n";

}else {

    echo "                      <tr>\n";
    echo "                        <td align=\"left\">{$lang['passwd']}:</td>\n";
    echo "                        <td align=\"left\">", form_input_password("new_passwd", "", 37, 0, "autocomplete=\"off\""), "&nbsp;</td>\n";
    echo "                      </tr>\n";
}

echo "                      <tr>\n";
echo "                        <td align=\"left\">{$lang['confirmpasswd']}:</td>\n";
echo "                        <td align=\"left\">", form_input_password("confirm_passwd", "", 37, 0, "autocomplete=\"off\""), "&nbsp;</td>\n";
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