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
require_once("./include/format.inc.php");

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

if (isset($HTTP_POST_VARS['logon'])) {

  if(isset($HTTP_POST_VARS['logon']) && isset($HTTP_POST_VARS['password'])) {

    if ((strtoupper($HTTP_POST_VARS['logon']) == 'GUEST') && ($HTTP_POST_VARS['submit'] == 'Logon')) {
    
      header("HTTP/1.0 500 Internal Server Error"); // Naughty naughty.
      exit;
      
    }else {
  
      $luid = user_logon(strtoupper($HTTP_POST_VARS['logon']), $HTTP_POST_VARS['password']);
    
    }
         
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
        
        if (($key = array_search($HTTP_POST_VARS['logon'], $usernames) !== false)) {
          $passwords[$key] = $HTTP_POST_VARS['password'];
        }
               
        for ($i = 0; $i < sizeof($usernames); $i++) {
        
          setcookie("bh_remember_user[$i]", _stripslashes($usernames[$i]), time() + YEAR_IN_SECONDS, dirname($HTTP_SERVER_VARS['PHP_SELF']). '/');

          if(@$HTTP_POST_VARS['remember_user'] == "Y") {
            setcookie("bh_remember_password[$i]", _stripslashes($passwords[$i]), time() + YEAR_IN_SECONDS, dirname($HTTP_SERVER_VARS['PHP_SELF']). '/');
          }else {
            setcookie("bh_remember_password[$i]", str_repeat(chr(255), 4), time() + YEAR_IN_SECONDS, dirname($HTTP_SERVER_VARS['PHP_SELF']). '/');
          }
          
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

      html_draw_top();
      echo "<h2>Invalid login. <a href=\"index.php\"> Go Back</a>.</h2>";
      html_draw_bottom();
      exit;

    }
    
  }else {
  
    $error_html = "<h2>A username and password is required</h2>";
  }
  
}

html_draw_top();

echo "<script language=\"javascript\" type=\"text/javascript\">\n";
echo "<!--\n\n";
echo "function changepassword() {\n\n";
echo "  i = document.logonform.logonarray.selectedIndex;\n";
echo "  p = eval(\"document.logonform.password\"+ i +\".value\");\n";
echo "  document.logonform.logon.value = document.logonform.logonarray.options[i].value;\n";
echo "  if (p == 'ÿÿÿÿ') {\n";
echo "    document.logonform.password.value = '';\n";
echo "    document.logonform.remember_user.checked = false;\n";
echo "  }else {\n";
echo "    document.logonform.password.value = p;\n";
echo "    document.logonform.remember_user.checked = true;\n";
echo "  }\n";
echo "}\n\n";
echo "var has_clicked = false;\n\n";
echo "//-->\n";
echo "</script>\n";
  
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
   
echo "<p>&nbsp;</p>\n";
echo "<div align=\"center\">\n";
echo "  <form name=\"logonform\" action=\"". get_request_uri() ."&". md5(uniqid(rand())). "\" method=\"POST\" target=\"_top\" onsubmit=\"return has_clicked;\">\n";
echo "    <table class=\"box\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\">\n";
echo "      <tr>\n";
echo "        <td>\n";
echo "          <table class=\"subhead\" width=\"100%\">\n";
echo "            <tr>\n";
echo "              <td>Logon:</td>\n";
echo "            </tr>\n";
echo "          </table>\n";
echo "          <table class=\"posthead\" width=\"100%\">\n";

if (!is_array($HTTP_COOKIE_VARS['bh_remember_user'])) {

  echo "            <tr>\n";
  echo "              <td align=\"right\">User Name:</td>\n";
  echo "              <td>". form_input_text("logon", _stripslashes($HTTP_COOKIE_VARS['bh_remember_user'])). "</td>\n";
  echo "            </tr>\n";
  echo "            <tr>\n";
  echo "              <td align=\"right\">Password:</td>\n";
  echo "              <td>". form_input_password("password", ($HTTP_COOKIE_VARS['bh_remember_password'] != str_repeat(chr(255), 4) ? $HTTP_COOKIE_VARS['bh_remember_password'] : "")). "</td>\n";
  echo "            </tr>\n";
  
}else {

  if ((sizeof($HTTP_COOKIE_VARS['bh_remember_user']) > 1) && $otherlogon == false) {

    echo "          <tr>\n";
    echo "            <td align=\"right\">User Name:</td>\n";
    echo "            <td>";

    $userkeys = array_keys($HTTP_COOKIE_VARS['bh_remember_user']);

    foreach ($userkeys as $key) {
      $usernames[$key] = _stripslashes($HTTP_COOKIE_VARS['bh_remember_user'][$key]);
    }
    
    echo form_dropdown_array('logonarray', $usernames, $usernames, "", "onchange='changepassword()'");
    echo form_input_hidden('logon', _stripslashes($HTTP_COOKIE_VARS['bh_remember_user'][0]));
  
    for ($i = 0; $i < sizeof($HTTP_COOKIE_VARS['bh_remember_user']); $i++) {
      if (isset($HTTP_COOKIE_VARS['bh_remember_password'][$i])) {
        echo form_input_hidden('password'. $i, $HTTP_COOKIE_VARS['bh_remember_password'][$i]);
      }else {
        echo form_input_hidden('password'. $i, str_repeat(chr(255), 4));
      }
    }
    
    echo "&nbsp;". form_button("other", "Other", "onclick=\"self.location.href='". get_request_uri(). "&other=true';\""). "</td>\n";
    
    echo "          </tr>\n";
    echo "          <tr>\n";
    echo "            <td align=\"right\">Password:</td>\n";
    echo "            <td>".form_input_password("password", ($HTTP_COOKIE_VARS['bh_remember_password'][0] != str_repeat(chr(255), 4) ? $HTTP_COOKIE_VARS['bh_remember_password'][0] : ""))."</td>\n";
    echo "          </tr>\n";
    
  }else {
  
    echo "          <tr>\n";
    echo "            <td align=\"right\">User Name:</td>\n";
    echo "            <td>". form_input_text("logon", _stripslashes($HTTP_COOKIE_VARS['bh_remember_user'][0])). "</td>\n";
    echo "          </tr>\n";
    echo "          <tr>\n";
    echo "            <td align=\"right\">Password:</td>\n";
    echo "            <td>". form_input_password("password", ($HTTP_COOKIE_VARS['bh_remember_password'][0] != str_repeat(chr(255), 4) ? $HTTP_COOKIE_VARS['bh_remember_password'][0] : "")). "</td>\n";
    echo "          </tr>\n";
    
  }
    
}

echo "            <tr>\n";
echo "              <td>&nbsp;</td>\n";
echo "              <td>";

echo form_checkbox("remember_user", "Y", "Remember password", ($HTTP_COOKIE_VARS['bh_remember_password'][0] != str_repeat(chr(255), 4)) && strlen($HTTP_COOKIE_VARS['bh_remember_password'][0]) > 0);

echo "</td>\n";
echo "            </tr>\n";
echo "          </table>\n";
echo "          <table class=\"posthead\" width=\"100%\">\n";
echo "            <tr>\n";
echo "              <td align=\"center\">";

echo form_submit('submit', 'Logon', 'onclick="has_clicked = true"');
//echo "<input type=\"submit\" name=\"submit\" value=\"Logon\" onclick=\"has_clicked = true\">\n";

echo "</td>\n";
echo "            </tr>\n";
echo "          </table>\n";
echo "        </td>\n";
echo "      </tr>\n";
echo "    </table>\n";
echo "  </form>\n";
echo "  <form name=\"guest\" action=\"". get_request_uri(). "&". md5(uniqid(rand())). "\" method=\"POST\" target=\"_top\">\n";
echo "    <p class=\"smalltext\">Enter as a ". form_input_hidden("logon", "guest"). form_input_hidden("password", "guest"). form_submit("submit", "Guest"). "</p>\n";
echo "  </form>\n";
echo "  <p class=\"smalltext\">Don't have an account? <a href=\"register.php?final_uri=" . urlencode($final_uri). "\" target=\"_self\">Register now.</a></p>\n";
echo "  <p class=\"smalltext\"><a href=\"forgot_pw.php\" target=\"_self\">Forgotten your password?</a></p>\n";
echo "</div>\n";

html_draw_bottom();

?>