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

require_once("./include/html.inc.php");
require_once("./include/user.inc.php");
require_once("./include/constants.inc.php");
require_once("./include/form.inc.php");
require_once("./include/db.inc.php");
require_once("./include/config.inc.php");

if (isset($HTTP_POST_VARS['submit'])) {

    if(isset($HTTP_POST_VARS['logon'])) {

        $logon = strtoupper($HTTP_POST_VARS['logon']);

        $conn = db_connect();
        $sql = "select UID, PASSWD, EMAIL from ". forum_table("USER") ." where LOGON = \"$logon\"";
        $result = db_query($sql,$conn);

        if($fa = db_fetch_array($result)){
            if(isset($fa['UID']) && isset($fa['EMAIL'])){
                $msg = "You requested this e-mail from $forum_name because you have forgotten your password.\n\n";
                $msg.= "Click the link below (or copy and paste it into your browser) to reset your password:\n\n";
                $msg.= "http://". $HTTP_SERVER_VARS['HTTP_HOST'];
                
                if (dirname($HTTP_SERVER_VARS['PHP_SELF']) != '/') {
                  $msg. dirname($HTTP_SERVER_VARS['PHP_SELF']);
                }
                
                $msg.= "/change_pw.php?u={$fa['UID']}&h={$fa['PASSWD']}";

                $header = "From: \"$forum_name\" <$forum_email>\n";
                $header.= "Reply-To: \"$forum_name\" <$forum_email>\n";
                $header.= "X-Mailer: PHP/". phpversion();

                @mail($fa['EMAIL'], "Your password reset request - $forum_name", $msg, $header);

                html_draw_top();

                echo "<h1>Password reset e-mail sent</h1>";
                echo "<p>&nbsp;</p>\n<div align=\"center\">\n";
                echo "<p class=\"smalltext\">You should receive an e-mail containing<br />\n";
                echo "a link to reset your password shortly.</p>\n";

                html_draw_bottom();
                exit;
            }
        }
    }
    $error_html = "<h2>A valid username is required</h2>";
}

html_draw_top();

echo "<h1>Forgot password</h1>";

if (isset($error_html)) echo $error_html;

echo "<p>&nbsp;</p>\n<div align=\"center\">\n";
echo "<p class=\"smalltext\">Enter your logon name below and an e-mail<br />\n";
echo "will be sent to the registered address for<br />\n";
echo "that account containing a link allowing you<br />\n";
echo "to change your password.</p>\n";
echo "<form name=\"forgot_pw\" action=\"". $HTTP_SERVER_VARS['PHP_SELF'] ."\" method=\"POST\">\n";
echo "<table class=\"box\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\">\n<tr>\n<td>\n";
echo "<table class=\"subhead\" width=\"100%\">\n<tr>\n<td>Forgot Password</td>\n";
echo "</tr>\n</table>\n";
echo "<table class=\"posthead\" width=\"100%\">\n";
echo "<tr>\n<td align=\"right\">User Name:</td>\n";
echo "<td>".form_input_text("logon",$logon)."</td></tr>\n";
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
