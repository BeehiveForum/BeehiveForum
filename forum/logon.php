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
require_once("./include/session.inc.php");
require_once("./include/header.inc.php");
require_once("./include/form.inc.php");

if(isset($HTTP_GET_VARS['final_uri'])){
    $final_uri = urldecode($HTTP_GET_VARS['final_uri']);
}else {
    $final_uri = dirname($HTTP_SERVER_VARS['PHP_SELF']) . "/";
}

if(bh_session_check()) {

    html_draw_top();
    echo "<p>User ID " . $HTTP_COOKIE_VARS['bh_sess_uid'] . " already logged in.</p>";
    echo "<p><a href=\"". $final_uri. "\" target=\"_top\">Continue</a></p>";
    html_draw_bottom();
    exit;
    
}

if (isset($HTTP_POST_VARS['submit'])) {

  if(isset($HTTP_POST_VARS['logon']) && isset($HTTP_POST_VARS['password'])) {
  
    $luid = user_logon(strtoupper($HTTP_POST_VARS['logon']), $HTTP_POST_VARS['password']);
    
    if($luid > -1){
    
      bh_session_init($luid);
        
      if($HTTP_POST_VARS['remember_user'] == "Y") {
        
        setcookie('bh_remember_user', $HTTP_POST_VARS['logon'], time() + YEAR_IN_SECONDS, '/');
        setcookie('bh_remember_password', $HTTP_POST_VARS['password'], time() + YEAR_IN_SECONDS, '/');
            
      } else {
        
        setcookie("bh_remember_user","", time() - YEAR_IN_SECONDS, '/');
        setcookie("bh_remember_password", time() - YEAR_IN_SECONDS, '/');
      }
      
      header_redirect("http://".$HTTP_SERVER_VARS['HTTP_HOST'].$final_uri);
        
    } else if($luid == -2){ // User is banned - everybody hide
        header("HTTP/1.0 500 Internal Server Error");
        exit;
    } else {

      $error_html = "<h2>Invalid login</h2>";

    }
    
  }else {
  
    $error_html = "<h2>A username and password is required</h2>";
  }
  
}

html_draw_top();

if (isset($error_html)) echo $error_html;

if(isset($HTTP_COOKIE_VARS['bh_remember_user'])) {

  $logon = $HTTP_COOKIE_VARS['bh_remember_user'];
  $password = $HTTP_COOKIE_VARS['bh_remember_password'];
  
}
    
echo "<p>&nbsp;</p>\n<div align=\"center\">\n";
echo "<form name=\"logon\" action=\"". $HTTP_SERVER_VARS['REQUEST_URI']. "&". md5(uniqid(rand())). "\" method=\"POST\">\n";
echo "<table class=\"box\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\">\n<tr>\n<td>\n";
echo "<table class=\"subhead\" width=\"100%\">\n<tr>\n<td>Logon:</td>\n";
echo "</tr>\n</table>\n";
echo "<table class=\"posthead\" width=\"100%\">\n";
echo "<tr>\n<td align=\"right\">User Name:</td>\n";
echo "<td>".form_input_text("logon",$logon)."</td>\n";
echo "</tr><tr><td align=\"right\">Password</td>\n";
echo "<td>".form_input_password("password",$password)."</td>\n";
echo "</tr><tr><td>&nbsp;</td><td align=\"right\">\n";
echo form_checkbox("remember_user","Y","Remember me",(isset($HTTP_COOKIE_VARS['bh_remember_user']) || (isset($HTTP_POST_VARS['remember_user']) && $HTTP_POST_VARS['remember_user'] == "Y")));
echo "</td></tr>\n";
echo "</table>\n";
echo "<table class=\"posthead\" width=\"100%\">\n";
echo "<tr><td align=\"center\">";
echo form_submit();
echo "</td></tr></table>\n";
echo "</td></tr></table>\n";
echo "</form></div>\n";
echo "<div align=\"center\">\n";
echo "<p class=\"smalltext\">\nDon't have an account? ";
echo "<a href=\"register.php?final_uri=" . urlencode($final_uri);
echo "\" target=\"_self\">Register now.</a></p>";
echo "</div>\n";

html_draw_bottom();

?>
