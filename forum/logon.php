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
require_once("./include/beehive.inc.php");

if(isset($HTTP_GET_VARS['final_uri'])){
    $final_uri = urldecode($HTTP_GET_VARS['final_uri']);
}else {
    $final_uri = "./discussion.php";
}

if (strstr($final_uri, 'logout.php')) {
    $final_uri = "./discussion.php";
}

if(bh_session_check()) {

    html_draw_top();
    echo "<p>User ID " . $HTTP_COOKIE_VARS['bh_sess_uid'] . " already logged in.</p>";
    echo "<p><a href=\"./index.php?". $final_uri. "\">Continue</a></p>";
    html_draw_bottom();
    exit;
    
}

if (isset($HTTP_POST_VARS['submit'])) {

  if(isset($HTTP_POST_VARS['logon']) && isset($HTTP_POST_VARS['password'])) {
  
    $luid = user_logon(strtoupper($HTTP_POST_VARS['logon']), $HTTP_POST_VARS['password']);
    
    if ($luid > -1) {
    
      // Reset Thread Mode      
      setcookie('bh_thread_mode', '', time() - YEAR_IN_SECONDS, '/');
    
      if ($HTTP_POST_VARS['submit'] == 'Guest') {
      
        bh_session_init(0); // Use UID 0 for guest account.
        
      }else {
    
        bh_session_init($luid);
        
        // Multiple usernames
        
        if (isset($HTTP_COOKIE_VARS['bh_remember_user'])) {
        
          if (is_array($HTTP_COOKIE_VARS['bh_remember_user'])) {
        
            $usernames = $HTTP_COOKIE_VARS['bh_remember_user'];
            $passwords = $HTTP_COOKIE_VARS['bh_remember_password'];
          
          }else {
        
            $usernames = array(0 => $HTTP_COOKIE_VARS['bh_remember_user']);
            $passwords = array(0 => $HTTP_COOKIE_VARS['bh_remember_password']);
            
          }
          
        }else {
        
          $usernames = array();
          $passwords = array();
          
        }
                
        if (!in_array($HTTP_POST_VARS['logon'], $usernames)) {
          $usernames[] = $HTTP_POST_VARS['logon'];
          $passwords[] = $HTTP_POST_VARS['password'];
        }
        
        for ($i = 0; $i < sizeof($usernames); $i++) {
          setcookie("bh_remember_user[$i]", $usernames[$i], time() + YEAR_IN_SECONDS, '/');
        }
        
        if(@$HTTP_POST_VARS['remember_user'] == "Y") {
        
          for ($i = 0; $i < sizeof($usernames); $i++) {
	    setcookie("bh_remember_password[$i]", $passwords[$i], time() + YEAR_IN_SECONDS, '/');
          }
            
        }else {
        
          setcookie("bh_remember_password", "", time() - YEAR_IN_SECONDS, '/');
          
        }         
        
      }

      if (!strstr(@$HTTP_SERVER_VARS['SERVER_SOFTWARE'], 'Microsoft-IIS')) { // Not IIS
     
          header_redirect("./index.php?final_uri=". urlencode($final_uri));
          
      }else { // IIS bug prevents redirect at same time as setting cookies.
      
          html_draw_top();
          
          // Try a Javascript redirect
          echo "<script language=\"javascript\" type=\"text/javascript\">\n";
          echo "<!--\n";
          echo "document.location.href = './index.php?final_uri=". urlencode($final_uri). "';\n";
          echo "//-->\n";
          echo "</script>";
          
          // If they're still here, Javascript's not working. Give up, give a link.
          echo "<div align=\"center\"><p>&nbsp;</p><p>&nbsp;</p>";
          echo "<p>You logged in successfully.</p>";
          echo form_quick_button("./index.php", "Continue", "final_uri", urlencode($final_uri));

          html_draw_bottom();
          exit;
          
      }
      
    }else if($luid == -2){ // User is banned - everybody hide
    
        header("HTTP/1.0 500 Internal Server Error");
        exit;
        
    }else {

      $error_html = "<h2>Invalid login</h2>";

    }
    
  }else {
  
    $error_html = "<h2>A username and password is required</h2>";
  }
  
}

html_draw_top();

if (sizeof($HTTP_COOKIE_VARS['bh_remember_user']) > 1) {

  echo "<script language=\"javascript\" type=\"text/javascript\">\n";
  echo "<!--\n\n";
  echo "function changepassword() {\n\n";
  echo "  i = document.logonform.logonarray.selectedIndex;\n";
  echo "  p = eval(\"document.logonform.password\"+ i +\".value\");\n";
  echo "  document.logonform.password.value = p;\n";
  echo "  document.logonform.logon.value = document.logonform.logonarray.options[i].value;\n";
  echo "}\n\n";
  echo "//-->\n";
  echo "</script>\n";
  
}

if (isset($error_html)) echo $error_html;

if (isset($HTTP_COOKIE_VARS['bh_remember_user'])) {
    $logon = $HTTP_COOKIE_VARS['bh_remember_user'];
    $password = $HTTP_COOKIE_VARS['bh_remember_password'];
} else {
    $logon = "";
    $password = "";
}

if (isset($HTTP_GET_VARS['other'])) {
  $otherlogon = true;
}else {
  $otherlogon = false;  
}
   
echo "<p>&nbsp;</p>\n<div align=\"center\">\n";
echo "<form name=\"logonform\" action=\"". get_request_uri() ."&". md5(uniqid(rand())). "\" method=\"POST\" target=\"_top\">\n";
echo "<table class=\"box\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\">\n<tr>\n<td>\n";
echo "<table class=\"subhead\" width=\"100%\">\n<tr>\n<td>Logon:</td>\n";
echo "</tr>\n</table>\n";
echo "<table class=\"posthead\" width=\"100%\">\n";

if (!is_array($HTTP_COOKIE_VARS['bh_remember_user'])) {

  echo "<tr>\n";
  echo "  <td align=\"right\">User Name:</td>\n";
  echo "  <td>". form_input_text("logon", $HTTP_COOKIE_VARS['bh_remember_user']). "</td>\n";
  echo "</tr>\n";
  echo "<tr>\n";
  echo "  <td align=\"right\">Password:</td>\n";
  echo "  <td>". form_input_password("password", $HTTP_COOKIE_VARS['bh_remember_password']). "</td>\n";
  echo "</tr>\n";
  
}else {

  if ((sizeof($HTTP_COOKIE_VARS['bh_remember_user']) > 1) && $otherlogon == false) {

    echo "<tr>\n";
    echo "<td align=\"right\">User Name:</td>\n";
    echo "<td>";
    echo form_dropdown_array('logonarray', $HTTP_COOKIE_VARS['bh_remember_user'], $HTTP_COOKIE_VARS['bh_remember_user'], "", "onchange='changepassword()'");
    echo form_input_hidden('logon', $HTTP_COOKIE_VARS['bh_remember_user'][0]);
  
    for ($i = 0; $i < sizeof($HTTP_COOKIE_VARS['bh_remember_password']); $i++) {
      echo form_input_hidden('password'. $i, $HTTP_COOKIE_VARS['bh_remember_password'][$i]);
    }
    
    echo "&nbsp;". form_button("other", "Other", "onclick=\"self.location.href='". get_request_uri(). "&other=true';\""). "</td>\n";
    echo "</tr>\n";
    echo "<tr>\n";
    echo "<td align=\"right\">Password:</td>\n";
    echo "<td>".form_input_password("password", $HTTP_COOKIE_VARS['bh_remember_password'][0])."</td>\n";
    echo "</tr>\n";
    
  }else {
  
    echo "<tr>\n";
    echo "  <td align=\"right\">User Name:</td>\n";
    echo "  <td>". form_input_text("logon", $HTTP_COOKIE_VARS['bh_remember_user'][0]). "</td>\n";
    echo "</tr>\n";
    echo "<tr>\n";
    echo "  <td align=\"right\">Password:</td>\n";
    echo "  <td>". form_input_password("password", $HTTP_COOKIE_VARS['bh_remember_password'][0]). "</td>\n";
    echo "</tr>\n";
    
  }
    
}

echo "<tr><td>&nbsp;</td><td>\n";
echo form_checkbox("remember_user","Y","Remember password",(isset($HTTP_COOKIE_VARS['bh_remember_user']) || (isset($HTTP_POST_VARS['remember_user']) && $HTTP_POST_VARS['remember_user'] == "Y")));
echo "</td></tr>\n";
echo "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>\n";
echo "</table>\n";
echo "<table class=\"posthead\" width=\"100%\">\n";
echo "<tr><td align=\"center\">";
echo form_submit();
echo "</td></tr></table>\n";
echo "</td></tr></table>\n";
echo "</form>\n";
echo "<form name=\"guest\" action=\"". get_request_uri(). "&". md5(uniqid(rand())). "\" method=\"POST\" target=\"_top\">\n";
echo "<p class=\"smalltext\">Enter as a ". form_input_hidden("logon", "guest"). form_input_hidden("password", "guest"). form_submit("submit", "Guest"). "</p>\n";
echo "</form></div>\n";
echo "<div align=\"center\">\n";
echo "<p class=\"smalltext\">\nDon't have an account? ";
echo "<a href=\"register.php?final_uri=" . urlencode($final_uri);
echo "\" target=\"_self\">Register now.</a></p>\n";
echo "<p class=\"smalltext\">";
echo "<a href=\"forgot_pw.php\" target=\"_self\">Forgotten your password?</a></p>\n";
echo "</div>\n";

html_draw_bottom();

?>
