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

/* $Id: admin_forum_set_passwd.php,v 1.14 2006-12-12 21:42:26 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "./include/");

// Compress the output
include_once(BH_INCLUDE_PATH. "gzipenc.inc.php");

// Enable the error handler
include_once(BH_INCLUDE_PATH. "errorhandler.inc.php");

// Installation checking functions
include_once(BH_INCLUDE_PATH. "install.inc.php");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Check that Beehive is installed correctly
check_install();

// Multiple forum support
include_once(BH_INCLUDE_PATH. "forum.inc.php");

// Fetch the forum settings
$forum_settings = forum_get_settings();

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

// Check we have a webtag

$webtag = get_webtag($webtag_search);

// Load language file

$lang = load_language_file();

if (!bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0)) {

    html_draw_top();
    echo "<h1>{$lang['accessdenied']}</h1>\n";
    echo "<p>{$lang['accessdeniedexp']}</p>";
    html_draw_bottom();
    exit;
}

if (!forum_get_setting('access_level', 2, false)) {

    html_draw_top();
    echo "<h2>{$lang['forumisnotrestricted']}</h2>\n";
    html_draw_bottom();
    exit;
}

if (!$fid = forum_get_setting('fid') ) {

    html_draw_top();
    echo "<h1>{$lang['accessdenied']}</h1>\n";
    echo "<p>{$lang['accessdeniedexp']}</p>";
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

if (isset($_POST['back'])) {
    header_redirect($ret);
}

html_draw_top();

echo "<h1>{$lang['admin']} &raquo; ", forum_get_setting('forum_name', false, 'A Beehive Forum'), " &raquo; {$lang['changepassword']}</h1>\n";

if (isset($_POST['submit'])) {

    $valid = true;

    if (isset($_POST['pw']) && strlen(trim(_stripslashes($_POST['pw']))) > 0) {

        if (isset($_POST['cpw']) && strlen(trim(_stripslashes($_POST['cpw']))) > 0) {

            if (trim(_stripslashes($_POST['pw'])) == trim(_stripslashes($_POST['cpw']))) {

                if (_htmlentities(trim(_stripslashes($_POST['pw']))) != trim(trim(_stripslashes($_POST['pw'])))) {

                    echo "<h2>{$lang['passwdmustnotcontainHTML']}</h2>\n";
                    $valid = false;
                }

                if (!preg_match("/^[a-z0-9_-]+$/i", trim(_stripslashes($_POST['pw'])))) {

                    echo "<h2>{$lang['passwordinvalidchars']}</h2>\n";
                    $valid = false;
                }

                if (strlen(trim(_stripslashes($_POST['pw']))) < 6) {

                    echo "<h2>{$lang['passwdtooshort']}</h2>\n";
                    $valid = false;
                }

                if ($valid) {

                    $t_password = trim(_stripslashes($_POST['pw']));
                }

            }else {

                echo "<h2>{$lang['passwdsdonotmatch']}</h2>\n";
                $valid = false;
            }

        }else {

            echo "<h2>{$lang['passwdrequired']}</h2>\n";
            $valid = false;
        }
    }

    if ($valid) {

        if (forum_update_access($forum_array['FID'], $forum_array['ACCESS_LEVEL'], $t_password)) {

            echo "<h2>{$lang['passwdchanged']}</h2>\n";
        }
    }
}

echo "<br />\n";
echo "<div align=\"center\">\n";
echo "<form name=\"passwd\" action=\"admin_forum_set_passwd.php\" method=\"post\" target=\"_self\">\n";
echo "  ", form_input_hidden('webtag', $webtag), "\n";
echo "  ", form_input_hidden('ret', $ret), "\n";
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
echo "                        <td align=\"left\">", form_field("pw", "", 37, 0, "password"), "&nbsp;</td>\n";
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
echo "      <td align=\"center\">", form_submit("submit", $lang['save']), "&nbsp;", form_submit("back", $lang['back']), "</td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "</form>\n";
echo "<div>\n";

html_draw_bottom();

?>