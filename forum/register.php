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

/* $Id: register.php,v 1.48 2003-08-03 00:26:12 decoyduck Exp $ */

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
require_once("./include/config.inc.php");
require_once("./include/fixhtml.inc.php");

// Where are we going after we've logged on?

if(isset($HTTP_GET_VARS['final_uri'])) {
    $final_uri = urldecode($HTTP_GET_VARS['final_uri']);
}

if (bh_session_get_value('UID')) {

    html_draw_top();
    echo "<div align=\"center\">\n";
    echo "<p>{$lang['user']} ", bh_session_get_value('LOGON'), " {$lang['alreadyloggedin']}.</p>\n";
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

  if (!isset($HTTP_POST_VARS['dob_year']) || !isset($HTTP_POST_VARS['dob_month']) || !isset($HTTP_POST_VARS['dob_day']) || !checkdate($HTTP_POST_VARS['dob_month'], $HTTP_POST_VARS['dob_day'], $HTTP_POST_VARS['dob_year'])) {
          $error_html .= "<h2>{$lang['birthdayrequired']}</h2>\n";
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

      // Profile section

      $firstname   = (isset($HTTP_POST_VARS['firstname']) && trim($HTTP_POST_VARS['firstname']) != "") ? trim($HTTP_POST_VARS['firstname']) : "";
      $lastname    = (isset($HTTP_POST_VARS['lastname']) && trim($HTTP_POST_VARS['lastname']) != "") ? trim($HTTP_POST_VARS['lastname']) : "";
      $dob         = $HTTP_POST_VARS['dob_year']."-".$HTTP_POST_VARS['dob_month']."-".$HTTP_POST_VARS['dob_day'];
      $sig_content = (isset($HTTP_POST_VARS['sig_content']) && trim($HTTP_POST_VARS['sig_content']) != "") ? trim($HTTP_POST_VARS['sig_content']) : "";

      if (isset($HTTP_POST_VARS['sig_html']) && $HTTP_POST_VARS['sig_html'] == "Y") {
          $sig_content = fix_html($sig_content);
          $sig_html = "Y";
      }else {
          $sig_content = _stripslashes($sig_content);
          $sig_html = "";
      }

      // Preferences section

      $email_notify       = (isset($HTTP_POST_VARS['notifybyemail']) && $HTTP_POST_VARS['notifybyemail'] == "Y") ? "Y" : "N";
      $notifyofnewpmemail = (isset($HTTP_POST_VARS['notifyofnewpmemail']) && $HTTP_POST_VARS['notifyofnewpmemail'] == "Y") ? "Y" : "N";
      $notifyofnewpm      = (isset($HTTP_POST_VARS['notifyofnewpm']) && $HTTP_POST_VARS['notifyofnewpm'] == "Y") ? "Y" : "N";
      $mark_as_of_int     = (isset($HTTP_POST_VARS['autohighinterest']) && $HTTP_POST_VARS['autohighinterest'] == "Y") ? "Y" : "N";
      $dl_saving          = (isset($HTTP_POST_VARS['daylightsaving']) && $HTTP_POST_VARS['daylightsaving'] == "Y") ? "Y" : "N";
      $timezone           = (isset($HTTP_POST_VARS['timezone'])) ? $HTTP_POST_VARS['timezone'] : 0;
      $language           = (isset($HTTP_POST_VARS['language'])) ? $HTTP_POST_VARS['language'] : $default_language;
      $forum_style        = (isset($HTTP_POST_VARS['forumstyle'])) ? $HTTP_POST_VARS['forumstyle'] : $default_style;

      if($new_uid > -1) {

          user_update_prefs($new_uid, $firstname, $lastname, $dob, "", "", $email_notify, $timezone, $dl_saving, $mark_as_of_int, "", "", $forum_style, "", 0, $language, $notifyofnewpmemail, $notifyofnewpm, 0);
          user_update_sig($new_uid, $sig_content, $sig_html);

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

          if (!_in_array($logon, $username_array)) {

            array_unshift($username_array, $logon);

            if(isset($HTTP_POST_VARS['remember_user']) && ($HTTP_POST_VARS['remember_user'] == 'Y')) {
              array_unshift($password_array, $passw);
              array_unshift($passhash_array, $passh);
            }else {
              array_unshift($password_array, str_repeat(chr(255), 4));
              array_unshift($passhash_array, str_repeat(chr(255), 4));
            }

          }else {

            if (($key = _array_search($logon, $username_array)) !== false) {

              // Remove the existing values

              $uncookie = array_splice($username_array, $key, 1);
              $pwcookie = array_splice($password_array, $key, 1);
              $phcookie = array_splice($passhash_array, $key, 1);

              // Push the username to the top of the array

              array_unshift($username_array, $logon);

              // Check to see if the password box was ticked
              // and push the password and passhash on to
              // their arrays if applicable.

              if (isset($HTTP_POST_VARS['remember_user']) && ($HTTP_POST_VARS['remember_user'] == 'Y')) {
                if (isset($pwcookie[0]) && isset($phcookie[0])) {
                  array_unshift($password_array, $pwcookie[0]);
                  array_unshift($passhash_array, $phcookie[0]);
                }else {
                  array_unshift($password_array, $passw);
                  array_unshift($passhash_array, $passh);
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

          // set / update the cookie that remembers if the user
          // has any logon form data.

          setcookie("bh_logon", "1", time() + YEAR_IN_SECONDS);

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

$available_styles = array();
$style_names = array();

if ($dir = @opendir('styles')) {
  while (($file = readdir($dir)) !== false) {
    if (is_dir("styles/$file") && $file != '.' && $file != '..') {
      if (@file_exists("./styles/$file/desc.txt")) {
        if ($fp = fopen("./styles/$file/desc.txt", "r")) {
          $available_styles[] = $file;
          $style_names[] = _htmlentities(fread($fp, filesize("styles/$file/desc.txt")));
          fclose($fp);
        }else {
          $available_styles[] = $file;
          $style_names[] = $file;
        }
      }
    }
  }
  closedir($dir);
}

$available_langs = lang_get_available(); // Get available languages
$available_langs_labels = array_merge(array($lang['browsernegotiation']), $available_langs);
array_unshift($available_langs, "");

$timezones = array("GMT -12h", "GMT -11h", "GMT -10h", "GMT -9h30m", "GMT -9h", "GMT -8h30m", "GMT -8h",
                   "GMT -7h", "GMT -6h", "GMT -5h", "GMT -4h", "GMT -3h30m", "GMT -3h", "GMT -2h", "GMT -1h",
                   "GMT", "GMT +1h", "GMT +2h", "GMT +3h",  "GMT +3h30m","GMT +4h", "GMT +4h30m", "GMT +5h",
                   "GMT +5h30m", "GMT +6h", "GMT +6h30m", "GMT +7h", "GMT +8h", "GMT +9h", "GMT +9h30m",
                   "GMT +10h", "GMT +10h30m", "GMT +11h", "GMT +11h30m", "GMT +12h", "GMT +13h", "GMT +14h");

$timezones_data = array(-12,-11,-10,-9.5,-9,-8.5,-8,-7,-6,-5,-4,-3.5,-3,-2,-1,0,1,2,3,3.5,4,4.5,5,5.5,
                        6,6.5,7,8,9,9.5,10,10.5,11,11.5,12,13,14);

html_draw_top();

echo "<h1>{$lang['userregistration']}</h1>\n";

if (strlen($error_html) > 0) {
    echo $error_html;
}else {
    echo "<br />\n";
}

?>
<div align="center">
<form name="register" action="<?php echo $HTTP_SERVER_VARS['PHP_SELF']; ?>" method="POST">
  <table class="box" cellpadding="0" cellspacing="0" align="center" width="500">
    <tr>
      <td>
        <table class="posthead" width="100%">
          <tr>
            <td class="subhead" colspan="2"><?php echo $lang['registrationinformationrequired']; ?></td>
          </tr>
          <tr>
            <td class="posthead" width="250">&nbsp;<?php echo $lang['username']; ?>:</td>
            <td><?php echo form_field("logon", (isset($HTTP_POST_VARS['logon']) ? _stripslashes(trim($HTTP_POST_VARS['logon'])) : ''), 35, 32); ?></td>
          </tr>
          <tr>
            <td class="posthead">&nbsp;<?php echo $lang['nickname']; ?>:</td>
            <td><?php echo form_field("nickname", (isset($HTTP_POST_VARS['nickname']) ? _stripslashes(trim($HTTP_POST_VARS['nickname'])) : ''), 35, 32); ?></td>
          </tr>
          <tr>
            <td class="posthead">&nbsp;<?php echo $lang['email']; ?>:</td>
            <td><?php echo form_field("email", (isset($HTTP_POST_VARS['email']) ? _stripslashes(trim($HTTP_POST_VARS['email'])) : ''), 35, 80); ?></td>
          </tr>
          <tr>
            <td class="posthead">&nbsp;<?php echo $lang['dateofbirth']; ?>:</td>
            <td><?php echo form_dob_dropdowns((isset($HTTP_POST_VARS['dob_year']) ? $HTTP_POST_VARS['dob_year'] : 0), (isset($HTTP_POST_VARS['dob_month']) ? $HTTP_POST_VARS['dob_month'] : 0), (isset($HTTP_POST_VARS['dob_day']) ? $HTTP_POST_VARS['dob_day'] : 0), true); ?></td>
          </tr>
          <tr>
            <td class="posthead">&nbsp;<?php echo $lang['passwd']; ?>:</td>
            <td><?php echo form_field("pw", (isset($HTTP_POST_VARS['pw']) ? _stripslashes(trim($HTTP_POST_VARS['pw'])) : ''), 35, 32,"password"); ?></td>
          </tr>
          <tr>
            <td class="posthead">&nbsp;<?php echo $lang['confirmpassword']; ?>:</td>
            <td><?php echo form_field("cpw", (isset($HTTP_POST_VARS['cpw']) ? _stripslashes(trim($HTTP_POST_VARS['cpw'])) : ''), 35, 32,"password"); ?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><?php echo form_checkbox("remember_user", "Y", $lang['rememberpasswd'], (isset($HTTP_POST_VARS['remember_user']) && $HTTP_POST_VARS['remember_user'] == "Y")); ?></td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td class="subhead" colspan="2"><?php echo $lang['profileinformationoptional']; ?></td>
          </tr>
          <tr>
            <td class="posthead">&nbsp;<?php echo $lang['firstname']; ?>:</td>
            <td><?php echo form_field("firstname", (isset($HTTP_POST_VARS['firstname']) ? _stripslashes(trim($HTTP_POST_VARS['firstname'])) : ''), 35, 32); ?></td>
          </tr>
          <tr>
            <td class="posthead">&nbsp;<?php echo $lang['lastname']; ?>:</td>
            <td><?php echo form_field("lastname", (isset($HTTP_POST_VARS['lastname']) ? _stripslashes(trim($HTTP_POST_VARS['lastname'])) : ''), 35, 32); ?></td>
          </tr>
          <tr>
            <td class="posthead" valign="top">&nbsp;<?php echo $lang['signature']; ?>:</td>
            <td><?php echo form_textarea("sig_content", (isset($HTTP_POST_VARS['sig_content']) ? _htmlentities(_stripslashes(trim($HTTP_POST_VARS['sig_content']))) : ''), 6, 32); ?>
          </tr>
         <tr>
           <td><bdo dir=\"{$lang['_textdir']}\">&nbsp;</bdo></td>
           <td><?php echo form_checkbox("sig_html", "Y", $lang['containsHTML'], (isset($HTTP_POST_VARS['sig_html']) && $HTTP_POST_VARS['sig_html'] == "Y")); ?></td>
         </tr>
          <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td class="subhead" colspan="2"><?php echo $lang['preferencesoptional']; ?></td>
          </tr>
          <tr>
            <td class="posthead">&nbsp;<?php echo $lang['alwaysnotifymeofrepliestome']; ?>:</td>
            <td><?php echo form_radio("notifybyemail", "Y", $lang['yes'], (isset($HTTP_POST_VARS['notifybyemail']) && $HTTP_POST_VARS['notifybyemail'] == "Y")), "&nbsp;", form_radio("notifybyemail", "N", $lang['no'], ((isset($HTTP_POST_VARS['notifybyemail']) && $HTTP_POST_VARS['notifybyemail'] == "N") || (!isset($HTTP_POST_VARS['notifybyemail'])))); ?></td>
          </tr>
          <tr>
            <td class="posthead">&nbsp;<?php echo $lang['notifyonnewprivatemessage']; ?>:</td>
            <td><?php echo form_radio("notifyofnewpmemail", "Y", $lang['yes'], (isset($HTTP_POST_VARS['notifyofnewpmemail']) && $HTTP_POST_VARS['notifyofnewpmemail'] == "Y")), "&nbsp;", form_radio("notifyofnewpmemail", "N", $lang['no'], ((isset($HTTP_POST_VARS['notifyofnewpmemail']) && $HTTP_POST_VARS['notifyofnewpmemail'] == "N") || (!isset($HTTP_POST_VARS['notifyofnewpmemail'])))); ?></td>
          </tr>
          <tr>
            <td class="posthead">&nbsp;<?php echo $lang['popuponnewprivatemessage']; ?>:</td>
            <td><?php echo form_radio("notifyofnewpm", "Y", $lang['yes'], (isset($HTTP_POST_VARS['notifyofnewpm']) && $HTTP_POST_VARS['notifyofnewpm'] == "Y")), "&nbsp;", form_radio("notifyofnewpm", "N", $lang['no'], ((isset($HTTP_POST_VARS['notifyofnewpm']) && $HTTP_POST_VARS['notifyofnewpm'] == "N") || (!isset($HTTP_POST_VARS['notifyofnewpm'])))); ?></td>
          </tr>
          <tr>
            <td class="posthead">&nbsp;<?php echo $lang['automatichighinterestonpost']; ?>:</td>
            <td><?php echo form_radio("autohighinterest", "Y", $lang['yes'], (isset($HTTP_POST_VARS['autohighinterest']) && $HTTP_POST_VARS['autohighinterest'] == "Y")), "&nbsp;", form_radio("autohighinterest", "N", $lang['no'], ((isset($HTTP_POST_VARS['autohighinterest']) && $HTTP_POST_VARS['autohighinterest'] == "N") || (!isset($HTTP_POST_VARS['autohighinterest'])))); ?></td>
          </tr>
          <tr>
            <td class="posthead">&nbsp;<?php echo $lang['daylightsaving']; ?>:</td>
            <td><?php echo form_radio("daylightsaving", "Y", $lang['yes'], (isset($HTTP_POST_VARS['daylightsaving']) && $HTTP_POST_VARS['daylightsaving'] == "Y")), "&nbsp;", form_radio("daylightsaving", "N", $lang['no'], ((isset($HTTP_POST_VARS['daylightsaving']) && $HTTP_POST_VARS['daylightsaving'] == "N") || (!isset($HTTP_POST_VARS['daylightsaving'])))); ?></td>
          </tr>
          <tr>
            <td class="posthead">&nbsp;<?php echo $lang['timezonefromGMT']; ?></td>
            <td><?php echo form_dropdown_array("timezone", $timezones_data, $timezones, (isset($HTTP_POST_VARS['timezone']) ? $HTTP_POST_VARS['timezone'] : 0)); ?></td>
          </tr>
          <tr>
            <td class="posthead">&nbsp;<?php echo $lang['preferredlang']; ?>:</td>
            <td><?php echo form_dropdown_array("language", $available_langs, $available_langs_labels, bh_session_get_value("LANGUAGE")); ?></td>
          </tr>
          <tr>
            <td class="posthead">&nbsp;<?php echo $lang['forumstyle']; ?></td>
            <td>
              <?php

                if (isset($HTTP_POST_VARS['forumstyle'])) {
                    $selected_style = $HTTP_POST_VARS['forumstyle'];
                    if (!in_array($selected_style, $available_styles)) {
                        $selected_style = $default_style;
                    }
                }else {
                  $selected_style = $default_style;
                }

                foreach ($available_styles as $key => $style) {
                  if (strtolower($style) == strtolower($selected_style)) {
                    break;
                  }
                }

                reset($available_styles);

                if (isset($key)) {
                  echo form_dropdown_array("forumstyle", $available_styles, $style_names, $available_styles[$key]);
                }else {
                  echo form_dropdown_array("forumstyle", $available_styles, $style_names, $available_styles[0]);
                }

              ?>
            </td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
  <p class="threadtime">More Profile and Preference options are available once you register.</p>
  <p><?php echo form_submit("submit", $lang['register']); ?></p>
</form>
</div>
<?php

html_draw_bottom();

?>
