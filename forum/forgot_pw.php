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

    if(isset($HTTP_POST_VARS['logon'])) {

        $logon = strtoupper($HTTP_POST_VARS['logon']);

        $conn = db_connect();
        $sql = "select UID, PASSWD, EMAIL from ". forum_table("USER") ." where LOGON = \"$logon\"";
        $result = db_query($sql,$conn);

        if($fa = db_fetch_array($result)) {

            if(isset($fa['UID']) && isset($fa['EMAIL'])) {

                $msg = "{$lang['forgotpwemail_1']} $forum_name {$lang['forgotpwemail_2']}\n\n";
                $msg.= "{$lang['forgotpwemail_3']}:\n\n";
                $msg.= "http://". $HTTP_SERVER_VARS['HTTP_HOST'];

                if (dirname($HTTP_SERVER_VARS['PHP_SELF']) != '/') {
                  $msg.= dirname($HTTP_SERVER_VARS['PHP_SELF']);
                }

                $msg.= "/change_pw.php?u={$fa['UID']}&h={$fa['PASSWD']}";

                $header = "From: \"$forum_name\" <$forum_email>\n";
                $header.= "Reply-To: \"$forum_name\" <$forum_email>\n";
                $header.= "X-Mailer: PHP/". phpversion();

                @mail($fa['EMAIL'], "{$lang['passwdresetrequest']} - $forum_name", $msg, $header);

                html_draw_top();

                echo "<h1>{$lang['passwdresetemailsent']}</h1>";
                echo "<p>&nbsp;</p>\n<div align=\"center\">\n";
                echo "<p class=\"smalltext\">{$lang['passwdresetexp_1']}<br />\n";
                echo "{$lang['passwdresetexp_2']}</p>\n";

                html_draw_bottom();
                exit;
            }
        }
    }

    $error_html = "<h2>{$lang['validusernamerequired']}</h2>";
}

if (!isset($logon)) $logon = "";

html_draw_top();

echo "<h1>{$lang['forgotpasswd']}</h1>";

if (isset($error_html)) echo $error_html;

echo "<p>&nbsp;</p>\n<div align=\"center\">\n";
echo "<p class=\"smalltext\">{$lang['forgotpasswdexp_1']}<br />\n";
echo "{$lang['forgotpasswdexp_2']}<br />\n";
echo "{$lang['forgotpasswdexp_3']}<br />\n";
echo "{$lang['forgotpasswdexp_4']}</p>\n";
echo "<form name=\"forgot_pw\" action=\"". $HTTP_SERVER_VARS['PHP_SELF'] ."\" method=\"POST\">\n";
echo "<table class=\"box\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\">\n<tr>\n<td>\n";
echo "<table class=\"subhead\" width=\"100%\">\n<tr>\n<td>{$lang['forgotpasswd']}</td>\n";
echo "</tr>\n</table>\n";
echo "<table class=\"posthead\" width=\"100%\">\n";
echo "<tr>\n<td align=\"right\">{$lang['username']}:</td>\n";
echo "<td>".form_input_text("logon", $logon)."</td></tr>\n";
echo "</table>\n";
echo "<table class=\"posthead\" width=\"100%\">\n";
echo "<tr><td align=\"center\">";
echo form_submit();
echo "</td></tr></table>\n";
echo "</td></tr></table>\n";
echo "</form>\n";
echo "</div>\n";

html_draw_bottom();

?>
