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

/* $Id: change_pw.php,v 1.11 2003-09-15 19:04:30 decoyduck Exp $ */

// Enable the error handler
require_once("./include/errorhandler.inc.php");

// Compress the output
require_once("./include/gzipenc.inc.php");

require_once("./include/html.inc.php");
require_once("./include/user.inc.php");
require_once("./include/constants.inc.php");
require_once("./include/form.inc.php");
require_once("./include/db.inc.php");
require_once("./include/config.inc.php");
require_once("./include/lang.inc.php");

if (isset($HTTP_POST_VARS['submit'])) {

    if (isset($HTTP_POST_VARS['uid']) && isset($HTTP_POST_VARS['pw']) && isset($HTTP_POST_VARS['cpw']) && isset($HTTP_POST_VARS['key'])) {

        if ($HTTP_POST_VARS['pw'] == $HTTP_POST_VARS['cpw']) {

	    if (user_change_pw($HTTP_POST_VARS['uid'], $HTTP_POST_VARS['pw'], $HTTP_POST_VARS['key'])) {

                html_draw_top();

                echo "<h1>{$lang['passwdchanged']}</h1>";
		echo "<br />\n";
                echo "<div align=\"center\">\n";
                echo "<p>{$lang['passedchangedexp']}</p>\n";

		form_quick_button("./index.php", $lang['continue'], "", "", "_top");

		echo "</div>\n";

                // -- html_draw_bottom is now handled by bh_gz_handler -- html_draw_bottom();
                exit;

            }else {
                $error_html = "<h2>{$lang['updatefailed']}.</h2>";
            }

        }else {
            $error_html = "<h2>{$lang['passwdsdonotmatch']}</h2>";
        }

    }else {
        $error_html = "<h2>{$lang['allfieldsrequired']}</h2>";
    }
}

if (isset($HTTP_GET_VARS['u']) && isset($HTTP_GET_VARS['h'])) {
    $uid = $HTTP_GET_VARS['u'];
    $key = $HTTP_GET_VARS['h'];
}elseif (isset($HTTP_POST_VARS['uid']) && isset($HTTP_POST_VARS['key'])) {
    $uid = $HTTP_POST_VARS['uid'];
    $key = $HTTP_POST_VARS['key'];
}else {
    html_draw_top();
    echo "<h1>{$lang['error']}</h1>\n";
    echo "<h2>{$lang['requiredinformationnotfound']}</h2>\n";
    // -- html_draw_bottom is now handled by bh_gz_handler -- html_draw_bottom();
    exit;
}

if ($user = user_get($uid, $key)) {
    $logon = strtoupper($user['LOGON']);
}else {
    html_draw_top();
    echo "<h1>{$lang['error']}</h1>\n";
    echo "<h2>{$lang['requiredinformationnotfound']}</h2></div>\n";
    // -- html_draw_bottom is now handled by bh_gz_handler -- html_draw_bottom();
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
echo "  <form name=\"forgot_pw\" action=\"". $HTTP_SERVER_VARS['PHP_SELF'] ."\" method=\"POST\">\n";
echo "  ", form_input_hidden("uid", $uid), form_input_hidden("key", $key), "\n";
echo "    <table class=\"box\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\">\n";
echo "      <tr>\n";
echo "        <td>\n";
echo "          <table class=\"subhead\" width=\"100%\">\n";
echo "            <tr>\n";
echo "              <td>{$lang['forgotpasswd']}</td>\n";
echo "            </tr>\n";
echo "          </table>\n";
echo "          <table class=\"posthead\" width=\"100%\">\n";
echo "            <tr>\n";
echo "              <td align=\"right\">{$lang['newpasswd']}:</td>\n";
echo "              <td>", form_input_password("pw", ""), "</td>\n";
echo "            </tr>\n";
echo "            <tr>\n";
echo "              <td align=\"right\">{$lang['confirmpasswd']}:</td>\n";
echo "              <td>", form_input_password("cpw", ""), "</td>\n";
echo "            </tr>\n";
echo "          </table>\n";
echo "          <table class=\"posthead\" width=\"100%\">\n";
echo "            <tr>\n";
echo "              <td align=\"center\">", form_submit(), "</td>\n";
echo "            </tr>\n";
echo "          </table>\n";
echo "        </td>\n";
echo "      </tr>\n";
echo "    </table>\n";
echo "  </form>\n";
echo "</div>\n";

// -- html_draw_bottom is now handled by bh_gz_handler -- html_draw_bottom();

?>