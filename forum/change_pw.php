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

    if(isset($HTTP_POST_VARS['uid']) && isset($HTTP_POST_VARS['pw']) && isset($HTTP_POST_VARS['cpw']) && isset($HTTP_POST_VARS['key'])) {

        if($HTTP_POST_VARS['pw'] == $HTTP_POST_VARS['cpw']){

            $newpass = md5($HTTP_POST_VARS['pw']);

            $db = db_connect();
            $sql = "update ". forum_table("USER") ." set PASSWD = \"$newpass\" ";
            $sql.= "where UID = '{$HTTP_POST_VARS['uid']}' and PASSWD = \"{$HTTP_POST_VARS['key']}\"";
            $result = db_query($sql, $db);
            $success = db_affected_rows($db);

            if ($success) {
                html_draw_top();

                echo "<h1>{$lang['passwdchanged']}</h1>";
                echo "<p>&nbsp;</p>\n<div align=\"center\">\n";
                echo "<p>{$lang['passwdchangedexp']}</p>\n";
                echo "<p><a href=\"logon.php\">{$lang['gotologin']}</a></p></div>";

                html_draw_bottom();
                exit;
            } else {
                $error_html = "<h2>{$lang['updatefailed']}.</h2>";
            }
            $uid = $HTTP_POST_VARS['uid'];
            $key = $HTTP_POST_VARS['key'];
        } else {
            $error_html = "<h2>{$lang['passwdsdonotmatch']}</h2>";
        }
    } else {
        $error_html = "<h2>{$lang['allfieldsrequired']}</h2>";
    }

} else if(!isset($HTTP_GET_VARS['u']) || !isset($HTTP_GET_VARS['h'])){
    html_draw_top();
    echo "<h1>{$lang['invalidaccess']}</h1>\n";
    echo "<p>&nbsp;</p>\n<div align=\"center\">\n";
    echo "<h2>{$lang['requiredinformationnotfound']}</h2></div>\n";
    html_draw_bottom();
    exit;
} else {
    $uid = $HTTP_GET_VARS['u'];
    $key = $HTTP_GET_VARS['h'];
}

$conn = db_connect();
$sql = "select LOGON from ". forum_table("USER") ." where UID = '$uid' and PASSWD = \"$key\"";
$result = db_query($sql,$conn);
if(!$fa = db_fetch_array($result)){
    html_draw_top();
    echo "<h1>{$lang['invalidaccess']}</h1>\n";
    echo "<p>&nbsp;</p>\n<div align=\"center\">\n";
    echo "<h2>{$lang['requiredinformationnotfound']}</h2></div>\n";
    html_draw_bottom();
    exit;
}

$logon = strtoupper($fa['LOGON']);

html_draw_top();

echo "<h1>{$lang['forgotpasswd']}</h1>";

if (isset($error_html)) echo $error_html;

echo "<p>&nbsp;</p>\n<div align=\"center\">\n";
echo "<p class=\"smalltext\">{$lang['enternewpasswdforuser']} $logon</p>\n";
echo "<form name=\"forgot_pw\" action=\"". $HTTP_SERVER_VARS['PHP_SELF'] ."\" method=\"POST\">\n";
echo "<table class=\"box\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\">\n<tr>\n<td>\n";
echo "<table class=\"subhead\" width=\"100%\">\n<tr>\n<td>{$lang['forgotpasswd']}</td>\n";
echo "</tr>\n</table>\n";
echo "<table class=\"posthead\" width=\"100%\">\n";
echo "<tr>\n<td align=\"right\">{$lang['newpasswd']}:</td>\n";
echo "<td>".form_input_text("pw","")."</td></tr>\n";
echo "<tr>\n<td align=\"right\">{$lang['confirmpasswd']}:</td>\n";
echo "<td>".form_input_text("cpw","")."</td></tr>\n";
echo "</table>\n";
echo form_input_hidden("uid",$uid);
echo form_input_hidden("key",$key);
echo "<table class=\"posthead\" width=\"100%\">\n";
echo "<tr><td align=\"center\">";
echo form_submit();
echo "</td></tr></table>\n";
echo "</td></tr></table>\n";
echo "</form>\n";
echo "</div>\n";

html_draw_bottom();

?>
