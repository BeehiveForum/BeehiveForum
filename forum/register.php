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

/* $Id: register.php,v 1.77 2004-03-22 12:21:16 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Multiple forum support
include_once("./include/forum.inc.php");

// Fetch the forum webtag and settings
$webtag = get_webtag();
$forum_settings = get_forum_settings();

include_once("./include/config.inc.php");
include_once("./include/constants.inc.php");
include_once("./include/fixhtml.inc.php");
include_once("./include/form.inc.php");
include_once("./include/format.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/session.inc.php");
include_once("./include/user.inc.php");

// Where are we going after we've logged on?

if (isset($HTTP_GET_VARS['final_uri'])) {
    $final_uri = rawurldecode($HTTP_GET_VARS['final_uri']);
}

if (bh_session_get_value('UID')) {

    html_draw_top();
    echo "<div align=\"center\">\n";
    echo "<p>{$lang['user']} ", bh_session_get_value('LOGON'), " {$lang['alreadyloggedin']}.</p>\n";
    
    if (isset($final_uri)) {
        form_quick_button("./index.php". $lang['continue'], "final_uri", $final_uri, "_top");
    }else {
        form_quick_button("./index.php". $lang['continue'], false, false, "_top");
    }
    
    echo "</div>\n";
    html_draw_bottom();
    exit;
}

$valid = true;
$error_html = "";

if (isset($HTTP_POST_VARS['submit'])) {

  if (strlen(trim($HTTP_POST_VARS['logon'])) > 0) {

      $t_logon = _stripslashes(trim($HTTP_POST_VARS['logon']));

      if (_htmlentities($t_logon) != $t_logon) {
        $error_html.= "<h2>{$lang['usernamemustnotcontainHTML']}</h2>\n";
        $valid = false;
      }
      
      if (!preg_match("/^[a-z0-9_-]+$/i", $t_logon)) {
        $error_html.= "<h2>{$lang['usernameinvalidchars']}</h2>\n";
        $valid = false;
      }
      
      if (strlen($t_logon) < 2) {
        $error_html.= "<h2>{$lang['usernametooshort']}</h2>\n";
        $valid = false;
      }
      
      if (strlen($t_logon) > 15) {
        $error_html.= "<h2>{$lang['usernametoolong']}</h2>\n";
        $valid = false;
      }
  }else {
      $error_html.= "<h2>{$lang['usernamerequired']}</h2>\n";
      $valid = false;
  }

  if (strlen(trim($HTTP_POST_VARS['pw'])) > 0) {

      $t_pw = _stripslashes(trim($HTTP_POST_VARS['pw']));
      
      if (_htmlentities($t_pw) != $t_pw) {
        $error_html.= "<h2>{$lang['passwdmustnotcontainHTML']}</h2>\n";
        $valid = false;
      }
      
      if (!preg_match("/^[a-z0-9_-]+$/i", $t_pw)) {
        $error_html.= "<h2>{$lang['passwordinvalidchars']}</h2>\n";
        $valid = false;
      }      
      
      if (strlen($t_pw) < 6) {
        $error_html.= "<h2>{$lang['passwdtooshort']}</h2>\n";
        $valid = false;
      }
      
  }else {
      $error_html.= "<h2>{$lang['passwdrequired']}</h2>\n";
      $valid.= false;
  }

  if (strlen(trim($HTTP_POST_VARS['cpw'])) > 0) {

      $t_cpw = _stripslashes(trim($HTTP_POST_VARS['cpw']));
      
      if (_htmlentities($t_cpw) != $t_cpw) {
        $error_html.= "<h2>{$lang['passwdmustnotcontainHTML']}</h2>\n";
        $valid = false;
      }
      
  }else {
      $error_html.= "<h2>{$lang['confirmationpasswdrequired']}</h2>\n";
      $valid = false;
  }

  if (strlen(trim($HTTP_POST_VARS['nickname'])) > 0) {
      
      $t_nickname = _stripslashes(trim($HTTP_POST_VARS['nickname']));
      
      if (_htmlentities($t_nickname) != $t_nickname) {
        $error_html.= "<h2>{$lang['nicknamemustnotcontainHTML']}</h2>\n";
        $valid = false;
      }
      
  }else {
      $error_html.= "<h2>{$lang['nicknamerequired']}</h2>\n";
      $valid = false;
  }

  if (strlen(trim($HTTP_POST_VARS['email'])) > 0) {
      
      $t_email = _stripslashes(trim($HTTP_POST_VARS['email']));
      
      if (_htmlentities($t_email) != $t_email) {
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
  
      if ($t_pw != $t_cpw) {
          $error_html.= "<h2>{$lang['passwdsdonotmatch']}</h2>\n";
          $valid = false;
      }
      
      if (strtolower($t_logon) == strtolower($t_pw)) {
        $error_html.= "<h2>{$lang['usernamesameaspasswd']}</h2>\n";
        $valid = false;
      }
  }

  if ($valid) {
      if (user_exists(strtoupper($t_logon))) {
          $error_html.= "<h2>{$lang['usernameexists']}</h2>\n";
          $valid = false;
      }
  }

  if ($valid) {

      $new_uid = user_create(strtoupper($t_logon), $t_pw, $t_nickname, $t_email);

      // Profile section
      
      $user_prefs['FIRSTNAME']   = (isset($HTTP_POST_VARS['firstname']) && trim($HTTP_POST_VARS['firstname']) != "") ? _stripslashes(trim($HTTP_POST_VARS['firstname'])) : "";
      $user_prefs['LASTNAME']    = (isset($HTTP_POST_VARS['lastname']) && trim($HTTP_POST_VARS['lastname']) != "") ? _stripslashes(trim($HTTP_POST_VARS['lastname'])) : "";
      $user_prefs['DOB']         = "{$HTTP_POST_VARS['dob_year']}-{$HTTP_POST_VARS['dob_month']}-{$HTTP_POST_VARS['dob_day']}";

      $sig_content = (isset($HTTP_POST_VARS['sig_content']) && trim($HTTP_POST_VARS['sig_content']) != "") ? trim($HTTP_POST_VARS['sig_content']) : "";

      if (isset($HTTP_POST_VARS['sig_html']) && $HTTP_POST_VARS['sig_html'] == "Y") {
          $sig_content = fix_html($sig_content);
          $sig_html = "Y";
      }else {
          $sig_content = _stripslashes($sig_content);
          $sig_html = "";
      }

      // Preferences section

      $user_prefs['EMAIL_NOTIFY']    = (isset($HTTP_POST_VARS['notifybyemail']) && $HTTP_POST_VARS['notifybyemail'] == "Y") ? "Y" : "N";
      $user_prefs['PM_NOTIFY_EMAIL'] = (isset($HTTP_POST_VARS['notifyofnewpmemail']) && $HTTP_POST_VARS['notifyofnewpmemail'] == "Y") ? "Y" : "N";
      $user_prefs['PM_NOTIFY']       = (isset($HTTP_POST_VARS['notifyofnewpm']) && $HTTP_POST_VARS['notifyofnewpm'] == "Y") ? "Y" : "N";
      $user_prefs['MARK_AS_OF_INT']  = (isset($HTTP_POST_VARS['autohighinterest']) && $HTTP_POST_VARS['autohighinterest'] == "Y") ? "Y" : "N";
      $user_prefs['DL_SAVING']       = (isset($HTTP_POST_VARS['daylightsaving']) && $HTTP_POST_VARS['daylightsaving'] == "Y") ? "Y" : "N";
      $user_prefs['TIMEZONE']        = (isset($HTTP_POST_VARS['timezone'])) ? $HTTP_POST_VARS['timezone'] : 0;
      $user_prefs['LANGUAGE']        = (isset($HTTP_POST_VARS['language'])) ? $HTTP_POST_VARS['language'] : forum_get_setting('default_language');
      $user_prefs['STYLE']           = (isset($HTTP_POST_VARS['forumstyle'])) ? $HTTP_POST_VARS['forumstyle'] : forum_get_setting('default_style');
      $user_prefs['EMOTICONS']       = (isset($HTTP_POST_VARS['forumemoticons'])) ? $HTTP_POST_VARS['forumemoticons'] : forum_get_setting('default_emoticons');

      if ($new_uid > -1) {

          user_update_prefs($new_uid, $user_prefs);
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
         
          $passw = str_repeat(chr(32), strlen($t_pw));
          $passh = md5(_stripslashes($t_pw));          

          if (($key = _array_search($t_logon, $username_array)) !== false) {

              unset($username_array[$key]);
              unset($password_array[$key]);
              unset($passhash_array[$key]);
          }

          array_unshift($username_array, $t_logon);
        
          if (isset($HTTP_POST_VARS['remember_user']) && ($HTTP_POST_VARS['remember_user'] == 'Y')) {
        
              array_unshift($password_array, $passw);
              array_unshift($passhash_array, $passh);

          }else {
        
              array_unshift($password_array, "");
              array_unshift($passhash_array, "");
          }

          // set / update the username and password cookies
        
          for ($i = 0; $i < sizeof($username_array); $i++) {

            bh_setcookie("bh_remember_username[$i]", $username_array[$i], time() + YEAR_IN_SECONDS);
            bh_setcookie("bh_remember_password[$i]", $password_array[$i], time() + YEAR_IN_SECONDS);
            bh_setcookie("bh_remember_passhash[$i]", $passhash_array[$i], time() + YEAR_IN_SECONDS);

          }

          // set / update the cookie that remembers if the user
          // has any logon form data.

          bh_setcookie("bh_logon", "1", time() + YEAR_IN_SECONDS);

          html_draw_top();

          echo "<div align=\"center\">\n";
          echo "<p>{$lang['userrecordcreated']}</p>\n";
          
          if (isset($final_uri)) {
              form_quick_button("./index.php", $lang['continue'], "final_uri", rawurlencode($final_uri), "_top");
          }else {
              form_quick_button("./index.php", $lang['continue'], false, false, "_top");
          }
          
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

array_multisort($style_names, $available_styles);


$available_emots = array();
$emot_names = array();

if ($dir = @opendir('emoticons')) {
    while (($file = readdir($dir)) !== false) {
        if (is_dir("emoticons/$file") && $file != '.' && $file != '..') {
            if (@file_exists("./emoticons/$file/desc.txt")) {
                if ($fp = fopen("./emoticons/$file/desc.txt", "r")) {
                    $available_emots[] = $file;
                    $emot_names[] = _htmlentities(fread($fp, filesize("emoticons/$file/desc.txt")));
                    fclose($fp);
                }else {
                    $available_emots[] = $file;
                    $emot_names[] = $file;
                }
            }
        }
    }
    closedir($dir);
}

array_multisort($emot_names, $available_emots);


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

echo "<div align=\"center\">\n";
echo "<form name=\"register\" action=\"register.php?webtag={$webtag['WEBTAG']}\" method=\"POST\">\n";
echo "  <table class=\"box\" cellpadding=\"0\" cellspacing=\"0\" align=\"center\" width=\"500\">\n";
echo "    <tr>\n";
echo "      <td>\n";
echo "        <table class=\"posthead\" width=\"100%\">\n";
echo "          <tr>\n";
echo "            <td class=\"subhead\" colspan=\"2\">", $lang['registrationinformationrequired'], "</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\" width=\"250\">&nbsp;", $lang['username'], ":</td>\n";
echo "            <td>", form_field("logon", (isset($HTTP_POST_VARS['logon']) ? _stripslashes(trim($HTTP_POST_VARS['logon'])) : ''), 35, 32), "</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">&nbsp;", $lang['passwd'], ":</td>\n";
echo "            <td>", form_field("pw", (isset($HTTP_POST_VARS['pw']) ? _stripslashes(trim($HTTP_POST_VARS['pw'])) : ''), 35, 32, "password"), "</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">&nbsp;", $lang['confirmpassword'], ":</td>\n";
echo "            <td>", form_field("cpw", (isset($HTTP_POST_VARS['cpw']) ? _stripslashes(trim($HTTP_POST_VARS['cpw'])) : ''), 35, 32, "password"), "</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">&nbsp;", $lang['nickname'], ":</td>\n";
echo "            <td>", form_field("nickname", (isset($HTTP_POST_VARS['nickname']) ? _stripslashes(trim($HTTP_POST_VARS['nickname'])) : ''), 35, 32), "</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">&nbsp;", $lang['email'], ":</td>\n";
echo "            <td>", form_field("email", (isset($HTTP_POST_VARS['email']) ? _stripslashes(trim($HTTP_POST_VARS['email'])) : ''), 35, 80), "</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">&nbsp;", $lang['dateofbirth'], ":</td>\n";
echo "            <td>", form_dob_dropdowns((isset($HTTP_POST_VARS['dob_year']) ? $HTTP_POST_VARS['dob_year'] : 0), (isset($HTTP_POST_VARS['dob_month']) ? $HTTP_POST_VARS['dob_month'] : 0), (isset($HTTP_POST_VARS['dob_day']) ? $HTTP_POST_VARS['dob_day'] : 0), true), "</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td>&nbsp;</td>\n";
echo "            <td>", form_checkbox("remember_user", "Y", $lang['rememberpasswd'], (isset($HTTP_POST_VARS['remember_user']) && $HTTP_POST_VARS['remember_user'] == "Y")), "</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td colspan=\"2\">&nbsp;</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td class=\"subhead\" colspan=\"2\">", $lang['profileinformationoptional'], "</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">&nbsp;", $lang['firstname'], ":</td>\n";
echo "            <td>", form_field("firstname", (isset($HTTP_POST_VARS['firstname']) ? _stripslashes(trim($HTTP_POST_VARS['firstname'])) : ''), 35, 32), "</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">&nbsp;", $lang['lastname'], ":</td>\n";
echo "            <td>", form_field("lastname", (isset($HTTP_POST_VARS['lastname']) ? _stripslashes(trim($HTTP_POST_VARS['lastname'])) : ''), 35, 32), "</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\" valign=\"top\">&nbsp;", $lang['signature'], ":</td>\n";
echo "            <td>", form_textarea("sig_content", (isset($HTTP_POST_VARS['sig_content']) ? _htmlentities(_stripslashes(trim($HTTP_POST_VARS['sig_content']))) : ''), 6, 32), "</td>\n";
echo "          </tr>\n";
echo "         <tr>\n";
echo "           <td>&nbsp;</td>\n";
echo "           <td>", form_checkbox("sig_html", "Y", $lang['containsHTML'], (isset($HTTP_POST_VARS['sig_html']) && $HTTP_POST_VARS['sig_html'] == "Y")), "</td>\n";
echo "         </tr>\n";
echo "          <tr>\n";
echo "            <td colspan=\"2\">&nbsp;</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td class=\"subhead\" colspan=\"2\">", $lang['preferencesoptional'], "</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">&nbsp;", $lang['alwaysnotifymeofrepliestome'], ":</td>\n";
echo "            <td>", form_radio("notifybyemail", "Y", $lang['yes'], (isset($HTTP_POST_VARS['notifybyemail']) && $HTTP_POST_VARS['notifybyemail'] == "Y")), "&nbsp;", form_radio("notifybyemail", "N", $lang['no'], ((isset($HTTP_POST_VARS['notifybyemail']) && $HTTP_POST_VARS['notifybyemail'] == "N") || (!isset($HTTP_POST_VARS['notifybyemail'])))), "</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">&nbsp;", $lang['notifyonnewprivatemessage'], ":</td>\n";
echo "            <td>", form_radio("notifyofnewpmemail", "Y", $lang['yes'], (isset($HTTP_POST_VARS['notifyofnewpmemail']) && $HTTP_POST_VARS['notifyofnewpmemail'] == "Y")), "&nbsp;", form_radio("notifyofnewpmemail", "N", $lang['no'], ((isset($HTTP_POST_VARS['notifyofnewpmemail']) && $HTTP_POST_VARS['notifyofnewpmemail'] == "N") || (!isset($HTTP_POST_VARS['notifyofnewpmemail'])))), "</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">&nbsp;", $lang['popuponnewprivatemessage'], ":</td>\n";
echo "            <td>", form_radio("notifyofnewpm", "Y", $lang['yes'], (isset($HTTP_POST_VARS['notifyofnewpm']) && $HTTP_POST_VARS['notifyofnewpm'] == "Y")), "&nbsp;", form_radio("notifyofnewpm", "N", $lang['no'], ((isset($HTTP_POST_VARS['notifyofnewpm']) && $HTTP_POST_VARS['notifyofnewpm'] == "N") || (!isset($HTTP_POST_VARS['notifyofnewpm'])))), "</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">&nbsp;", $lang['automatichighinterestonpost'], ":</td>\n";
echo "            <td>", form_radio("autohighinterest", "Y", $lang['yes'], (isset($HTTP_POST_VARS['autohighinterest']) && $HTTP_POST_VARS['autohighinterest'] == "Y")), "&nbsp;", form_radio("autohighinterest", "N", $lang['no'], ((isset($HTTP_POST_VARS['autohighinterest']) && $HTTP_POST_VARS['autohighinterest'] == "N") || (!isset($HTTP_POST_VARS['autohighinterest'])))), "</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">&nbsp;", $lang['daylightsaving'], ":</td>\n";
echo "            <td>", form_radio("daylightsaving", "Y", $lang['yes'], (isset($HTTP_POST_VARS['daylightsaving']) && $HTTP_POST_VARS['daylightsaving'] == "Y")), "&nbsp;", form_radio("daylightsaving", "N", $lang['no'], ((isset($HTTP_POST_VARS['daylightsaving']) && $HTTP_POST_VARS['daylightsaving'] == "N") || (!isset($HTTP_POST_VARS['daylightsaving'])))), "</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">&nbsp;", $lang['timezonefromGMT'], "</td>\n";
echo "            <td>", form_dropdown_array("timezone", $timezones_data, $timezones, (isset($HTTP_POST_VARS['timezone']) ? $HTTP_POST_VARS['timezone'] : 0)), "</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">&nbsp;", $lang['preferredlang'], ":</td>\n";
echo "            <td>", form_dropdown_array("language", $available_langs, $available_langs_labels, bh_session_get_value("LANGUAGE")), "</td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">&nbsp;", $lang['forumstyle'], "</td>\n";
echo "            <td>";

if (isset($HTTP_POST_VARS['forumstyle'])) {
    $selected_style = $HTTP_POST_VARS['forumstyle'];
    if (!in_array($selected_style, $available_styles)) {
        $selected_style = forum_get_setting('default_style');
    }
}else {
    $selected_style = forum_get_setting('default_style');
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

echo "            </td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td class=\"posthead\">&nbsp;", $lang['forumemoticons'], "</td>\n";
echo "            <td>";

if (isset($HTTP_POST_VARS['forumemoticons'])) {
    $selected_emoticon = $HTTP_POST_VARS['forumemoticons'];
    if (!in_array($selected_emoticon, $available_emots)) {
        $selected_emoticon = forum_get_setting('default_emoticons');
    }
}else {
    $selected_emoticon = forum_get_setting('default_emoticons');
}

foreach ($available_emots as $key => $emoticon) {
    if (strtolower($emoticon) == strtolower($selected_emoticon)) {
        break;
    }
}

reset($available_emots);

if (isset($key)) {
    echo form_dropdown_array("forumemoticons", $available_emots, $emot_names, $available_emots[$key]);
}else {
    echo form_dropdown_array("forumemoticons", $available_emots, $emot_names, $available_emots[0]);
}

echo "            </td>\n";
echo "          </tr>\n";
echo "          <tr>\n";
echo "            <td colspan=\"2\">&nbsp;</td>\n";
echo "          </tr>\n";
echo "        </table>\n";
echo "      </td>\n";
echo "    </tr>\n";
echo "  </table>\n";
echo "  <p class=\"threadtime\">More Profile and Preference options are available once you register.</p>\n";
echo "  <p>", form_submit("submit", $lang['register']), "</p>\n";
echo "</form>\n";
echo "</div>\n";

html_draw_bottom();

?>