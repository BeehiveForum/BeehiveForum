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
require_once("./include/session.inc.php");
require_once("./include/form.inc.php");
require_once("./include/format.inc.php");
require_once("./include/lang.inc.php");

// Where are we going after we've logged on?

if(isset($HTTP_GET_VARS['final_uri'])) {
    $final_uri = urldecode($HTTP_GET_VARS['final_uri']);
}

if(bh_session_get_value('UID')){

    html_draw_top();
    echo "<div align=\"center\">\n";
    echo "<p>{$lang['userID']} ", bh_session_get_value('UID'), " {$lang['alreadyloggedin']}.</p>\n";
    echo form_quick_button("./index.php". (isset($final_uri) ? "?$final_uri" : ""), $lang['continue'], 0, 0, "_top");
    echo "</div>\n";
    html_draw_bottom();
    exit;
}

$valid = true;
$error_html = "";

if(isset($HTTP_POST_VARS['submit'])) {

  if (strlen(trim($HTTP_POST_VARS['logon'])) > 0) {
      if (_htmlentities(trim($HTTP_POST_VARS['logon'])) != trim($HTTP_POST_VARS['logon'])) {
        $error_html.= "<h2>{$lang['usernamemustnotcontainHTML']}</h2>\n";
        $valid = false;
      }
      if (!preg_match("/^[a-z0-9_-]+$/i", trim($HTTP_POST_VARS['logon']))) {
        $error_html.= "<h2>{$lang['usernameinvalidchars']}</h2>\n";
        $valid = false;
      }
      if (strlen(trim($HTTP_POST_VARS['logon'])) < 2) {
        $error_html.= "<h2>{$lang['usernametooshort']}</h2>\n";
        $valid = false;
      }
      if (strlen(trim($HTTP_POST_VARS['logon'])) > 15) {
        $error_html.= "<h2>{$lang['usernametoolong']}</h2>\n";
        $valid = false;
      }
  }else {
      $error_html.= "<h2>{$lang['usernamerequired']}</h2>\n";
      $valid = false;
  }

  if (strlen(trim($HTTP_POST_VARS['pw'])) > 0) {
      if (_htmlentities(trim($HTTP_POST_VARS['pw'])) != trim($HTTP_POST_VARS['pw'])) {
        $error_html.= "<h2>{$lang['passwdmustnotcontainHTML']}</h2>\n";
        $valid = false;
      }
      if (strlen(trim($HTTP_POST_VARS['pw'])) < 6) {
        $error_html.= "<h2>{$lang['passwdtooshort']}</h2>\n";
        $valid = false;
      }
  }else {
      $error_html.= "<h2>{$lang['passwdrequired']}</h2>\n";
      $valid.= false;
  }

  if (strlen(trim($HTTP_POST_VARS['cpw'])) > 0) {
      if (_htmlentities($HTTP_POST_VARS['cpw']) != $HTTP_POST_VARS['cpw']) {
        $error_html.= "<h2>{$lang['passwdmustnotcontainHTML']}</h2>\n";
        $valid = false;
      }
  }else {
      $error_html.= "<h2>{$lang['confirmationpasswdrequired']}</h2>\n";
      $valid = false;
  }

  if (strlen(trim($HTTP_POST_VARS['nickname'])) > 0) {
      if (_htmlentities($HTTP_POST_VARS['nickname']) != $HTTP_POST_VARS['nickname']) {
        $error_html.= "<h2>{$lang['nicknamemustnotcontainHTML']}</h2>\n";
        $valid = false;
      }
  }else {
      $error_html.= "<h2>{$lang['nicknamerequired']}</h2>\n";
      $valid = false;
  }

  if (strlen(trim($HTTP_POST_VARS['email'])) > 0) {
      if (_htmlentities($HTTP_POST_VARS['email']) != $HTTP_POST_VARS['email']) {
        $error_html.= "<h2>{$lang['emailmustnotcontainHTML']}</h2>\n";
        $valid = false;
      }
  }else {
      $error_html.= "<h2>{$lang['emailrequired']}</h2>\n";
      $valid = false;
  }


  if ($valid) {
      if($HTTP_POST_VARS['pw'] != $HTTP_POST_VARS['cpw']) {
          $error_html.= "<h2>{$lang['passwdsdonotmatch']}</h2>\n";
          $valid = false;
      }
      if (trim($HTTP_POST_VARS['logon']) == trim($HTTP_POST_VARS['pw'])) {
        $error_html.= "<h2>{$lang['usernamesameaspasswd']}</h2>\n";
        $valid = false;
      }
  }

  if ($valid) {
      if(user_exists(strtoupper(trim($HTTP_POST_VARS['logon'])))) {
          $error_html.= "<h2>{$lang['usernameexists']}</h2>\n";
          $valid = false;
      }
  }

  if($valid) {

      $new_uid = user_create(strtoupper(trim($HTTP_POST_VARS['logon'])), trim($HTTP_POST_VARS['pw']), trim($HTTP_POST_VARS['nickname']), trim($HTTP_POST_VARS['email']));

      if($new_uid > -1) {

          bh_session_init($new_uid);

          // Retrieve existing cookie data if any

          // Username array

          if (isset($HTTP_COOKIE_VARS['bh_remember_username']) && is_array($HTTP_COOKIE_VARS['bh_remember_username'])) {
              $username_array = $HTTP_COOKIE_VARS['bh_remember_username'];
          }else {
              $username_array = array();
          }

          // Password array

          if (isset($HTTP_COOKIE_VARS['bh_remember_password']) && is_array($HTTP_COOKIE_VARS['bh_remember_password'])) {
              $password_array = $HTTP_COOKIE_VARS['bh_remember_password'];
          }else {
              $password_array = array();
          }

          // Passhash array

          if (isset($HTTP_COOKIE_VARS['bh_remember_passhash']) && is_array($HTTP_COOKIE_VARS['bh_remember_passhash'])) {
              $passhash_array = $HTTP_COOKIE_VARS['bh_remember_passhash'];
          }else {
              $passhash_array = array();
          }

          // Prepare Form Data

          $logon = _stripslashes($HTTP_POST_VARS['logon']);
          $passw = str_repeat(chr(32), strlen(_stripslashes($HTTP_POST_VARS['pw'])));
          $passh = md5(_stripslashes($HTTP_POST_VARS['pw']));

          // Check to see if Form Data already exists in cookie

          if (!in_array($logon, $username_array)) {

            array_unshift($username_array, $logon);

            if(isset($HTTP_POST_VARS['remember_user']) && ($HTTP_POST_VARS['remember_user'] == 'Y')) {
              array_unshift($password_array, $passw);
              array_unshift($passhash_array, $passh);
            }else {
              array_unshift($password_array, str_repeat(chr(255), 4));
              array_unshift($passhash_array, str_repeat(chr(255), 4));
            }

          }else {

            if (($key = array_search($logon, $username_array)) !== false) {

              $uncookie = array_splice($username_array, $key, 1);
              $pwcookie = array_splice($password_array, $key, 1);
              $phcookie = array_splice($passhash_array, $key, 1);

              array_unshift($username_array, $uncookie[0]);

              if(isset($HTTP_POST_VARS['remember_user']) && ($HTTP_POST_VARS['remember_user'] == 'Y')) {
                if ($pwcookie[0] == str_repeat(chr(255), 4)) {
                  array_unshift($password_array, $passw);
                  array_unshift($passhash_array, $passh);
                }else {
                  array_unshift($password_array, $pwcookie[0]);
                  array_unshift($passhash_array, $phcookie[0]);
                }
              }else {
                array_unshift($password_array, str_repeat(chr(255), 4));
                array_unshift($passhash_array, str_repeat(chr(255), 4));
              }

            }

          }

          // Set the cookies

          for ($i = 0; $i < sizeof($username_array); $i++) {

            setcookie("bh_remember_username[$i]", $username_array[$i], time() + YEAR_IN_SECONDS);
            setcookie("bh_remember_password[$i]", $password_array[$i], time() + YEAR_IN_SECONDS);
            setcookie("bh_remember_passhash[$i]", $passhash_array[$i], time() + YEAR_IN_SECONDS);

          }

          html_draw_top();

          echo "<div align=\"center\">\n";
          echo "<p>{$lang['userrecordcreated']}</p>\n";
          echo form_quick_button("./index.php". (isset($final_uri) ? "?$final_uri" : ""), "Continue", 0, 0, "_top");
          echo "</div>\n";

          html_draw_bottom();
          exit;

      } else {

          $error_html.= "<h2>{$lang['errorcreatinguserrecord']}</h2>\n";
          $valid = false;

      }
  }

}

html_draw_top();

echo "<h1>{$lang['userregistration']}</h1>\n";

if (isset($error_html)) echo $error_html;

?>
<p>&nbsp;</p>
<div align="center">
<form name="register" action="<?php echo $HTTP_SERVER_VARS['PHP_SELF']; ?>" method="POST">
  <table class="box" cellpadding="0" cellspacing="0" align="center">
    <tr>
      <td>
        <table class="subhead" width="100%">
          <tr>
            <td><?php echo $lang['register']; ?></td>
          </tr>
        </table>
        <table class="posthead" width="100%">
          <tr>
            <td align="right" class="posthead"><?php echo $lang['username']; ?>&nbsp;</td>
            <td><?php echo form_field("logon", (isset($HTTP_POST_VARS['logon']) ? _stripslashes(trim($HTTP_POST_VARS['logon'])) : ''), 32, 32); ?></td>
          </tr>
          <tr>
            <td align="right" class="posthead"><?php echo $lang['passwd']; ?>&nbsp;</td>
            <td><?php echo form_field("pw", (isset($HTTP_POST_VARS['pw']) ? _stripslashes(trim($HTTP_POST_VARS['pw'])) : ''), 32, 32,"password"); ?></td>
          </tr>
          <tr>
            <td align="right" class="posthead"><?php echo $lang['confirm']; ?>&nbsp;</td>
            <td><?php echo form_field("cpw", (isset($HTTP_POST_VARS['cpw']) ? _stripslashes(trim($HTTP_POST_VARS['cpw'])) : ''), 32, 32,"password"); ?></td>
          </tr>
          <tr>
            <td align="right" class="posthead"><?php echo $lang['nickname']; ?>&nbsp;</td>
            <td><?php echo form_field("nickname", (isset($HTTP_POST_VARS['nickname']) ? _stripslashes(trim($HTTP_POST_VARS['nickname'])) : ''), 32, 32); ?></td>
          </tr>
          <tr>
            <td align="right" class="posthead"><?php echo $lang['email']; ?>&nbsp;</td>
            <td><?php echo form_field("email", (isset($HTTP_POST_VARS['email']) ? _stripslashes(trim($HTTP_POST_VARS['email'])) : ''), 32, 80); ?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><?php echo form_checkbox("remember_user", "Y", $lang['rememberpasswd'], (isset($HTTP_POST_VARS['remember_user']) && $HTTP_POST_VARS['remember_user'] == "Y")); ?></td>
          </tr>
        </table>
        <table class="posthead" width="100%">
          <tr>
            <td align="center"><?php echo form_submit("submit", $lang['register']); ?></td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</form>
</div>

<?php

html_draw_bottom();

?>
