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
require_once("./include/form.inc.php");

// Where are we going after we've logged on?
if(isset($HTTP_GET_VARS['final_uri'])){
    $final_uri = urldecode($HTTP_GET_VARS['final_uri']);
} else {
    $final_uri = dirname($HTTP_SERVER_VARS['PHP_SELF']) . "/";
}

if(isset($HTTP_COOKIE_VARS['bh_sess_uid'])){
    html_draw_top();
    echo "<p>User ID " . $HTTP_COOKIE_VARS['bh_sess_uid'] . " already logged in.</p>";
    echo "<p><a href=\"$final_uri\" target=\"_top\">Continue</a></p>";
    html_draw_bottom();
    exit;
}

$valid = true;

if(isset($HTTP_POST_VARS['submit'])) {

  if(isset($HTTP_POST_VARS['logon'])) {
      if (htmlentities($HTTP_POST_VARS['logon']) != $HTTP_POST_VARS['logon']) {
        $logon = "plaintext";
        $valid = false;
      }else {
        $logon = $HTTP_POST_VARS['logon'];
      }
  }else {
      $logon = "";
      $valid = false;
  }

  if(isset($HTTP_POST_VARS['pw'])) {
      if (htmlentities($HTTP_POST_VARS['pw']) != $HTTP_POST_VARS['pw']) {
        $password = "plaintext";
        $valid = false;
      }else {
        $password = $HTTP_POST_VARS['pw'];
      }
  }else {
      $password = "";
      $valid = false;
  }

  if(isset($HTTP_POST_VARS['cpw'])) {
      if (htmlentities($HTTP_POST_VARS['cpw']) != $HTTP_POST_VARS['cpw']) {
        $cpassword = "plaintext";
        $valid = false;
      }else {
        $cpassword = $HTTP_POST_VARS['cpw'];
      }
  }else {
      $cpassword = "";
      $valid = false;
  }

  if(isset($HTTP_POST_VARS['nickname'])) {
      if (htmlentities($HTTP_POST_VARS['nickname']) != $HTTP_POST_VARS['nickname']) {
        $nickname = "plaintext";
        $valid = false;
      }else {
        $nickname = $HTTP_POST_VARS['nickname'];
      }
  }else {
      $nickname = "";
      $valid = false;
  }

  if(isset($HTTP_POST_VARS['email'])) {
      if (htmlentities($HTTP_POST_VARS['email']) != $HTTP_POST_VARS['email']) {
        $email = "plaintext";
        $valid = false;
      }else {
        $email = $HTTP_POST_VARS['email'];
      }
  }else {
      $email = "";
      $valid = false;
  }
  
  $remember_user = $HTTP_POST_VARS['remember_user'];

  if($logon=="") {
      $error_html = "<h2>A logon name is required</h2>";
      $valid = false;
  }else if($password=="") {
      $error_html = "<h2>A password is required</h2>";
      $valid = false;
  }else if($cpassword=="") {
      $error_html = "<h2>A confirmation password is required</h2>";
      $valid = false;
  }else if($nickname=="") {
      $error_html = "<h2>A nickname is required</h2>";
      $valid = false;
  }else if($email=="") {
      $error_html = "<h2>An email address is required</h2>";
      $valid = false;
  }

  if($logon=="plaintext") {
      $error_html = "<h2>Fields must not contain HTML tags</h2>";
      $valid = false;
      $logon = "";
  }
  
  if($password=="plaintext") {
      $error_html = "<h2>Fields must not contain HTML tags</h2>";
      $valid = false;
      $password = "";
  }
  
  if($cpassword=="plaintext") {
      $error_html = "<h2>Fields must not contain HTML tags</h2>";
      $valid = false;
      $cpassword = "";
  }
  
  if($nickname=="plaintext") {
      $error_html = "<h2>Fields must not contain HTML tags</h2>";
      $valid = false;
      $nickname = "";
  }
  
  if($email=="plaintext") {
      $error_html = "<h2>Fields must not contain HTML tags</h2>";
      $valid = false;
      $email = "";
  }

  if($valid) {
      if(user_exists($logon)) {
          $error_html = "<h2>Sorry, a user with that name already exists</h2>";
          $valid = false;
      }
  }

  if($valid) {
      if(!($password == $cpassword)) {
          $error_html = "<h2>Passwords do not match</h2>";
          $valid = false;
      }
  }

  if($valid) {
      $new_uid = user_create($logon,$password,$nickname,$email);
      if($new_uid > -1) {
          bh_session_init($new_uid);
          
          if($remember_user == "Y") {
        
            setcookie('bh_remember_user', $HTTP_POST_VARS['logon'], time() + YEAR_IN_SECONDS, '/');
            setcookie('bh_remember_password', $HTTP_POST_VARS['pw'], time() + YEAR_IN_SECONDS, '/');
            
          }else {
        
            setcookie("bh_remember_user","", time() - YEAR_IN_SECONDS, '/');
            setcookie("bh_remember_password", time() - YEAR_IN_SECONDS, '/');
    
          }
          
          html_draw_top();
          echo "<div align=\"center\">\n";
          echo "<p>Huzzah! Your user record has been created successfully!</p>\n";
          echo "<p><a href=\"$final_uri\" target=\"_top\">Continue</a></p>\n";      
          echo "</div>\n";
          html_draw_bottom();
          exit;
      } else {
          $error_html = "<h2>Error creating user record</h2>";
          $valid = false;
      }
  }
  
}

html_draw_top();

echo "<h1>User Registration</h1>";

if(isset($error_html)) echo $error_html;

echo "<div align=\"center\">";
echo "<form name=\"register\" action=\"" . $HTTP_SERVER_VARS['PHP_SELF'] . "\" method=\"POST\">";
echo "<table>";
echo "<tr><td align=\"right\" class=\"posthead\">Login Name :&nbsp;</td>";
echo "<td>".form_field("logon", $logon, 32, 32)."</td>";
echo "</tr><tr><td align=\"right\" class=\"posthead\">Password :&nbsp;</td>";
echo "<td>".form_field("pw", $password, 32, 32,"password")."</td>";
echo "</tr><tr><td align=\"right\" class=\"posthead\">Confirm :&nbsp;</td>";
echo "<td>".form_field("cpw", $cpassword, 32, 32,"password")."</td>";
echo "</tr><tr><td align=\"right\" class=\"posthead\">Nickname :&nbsp;</td>";
echo "<td>".form_field("nickname", $nickname, 32, 32)."</td>";
echo "</tr><tr><td align=\"right\" class=\"posthead\">Email :&nbsp;</td>";
echo "<td>".form_field("email", $email, 32, 80)."</td>";
echo "</tr><tr><td>&nbsp;</td>";
echo "<td>". form_checkbox("remember_user", "Y", "Remember me", ($remember_user == "Y")). "</td>";
echo "</tr><tr><td>&nbsp;</td><td>&nbsp;</td></tr></table>";
echo form_submit("submit", "Register");
echo "</form>";

html_draw_bottom();
?>