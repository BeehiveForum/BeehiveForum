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
require_once("./include/header.inc.php");
require_once("./include/form.inc.php");
require_once("./include/beehive.inc.php");
require_once("./include/format.inc.php");
require_once("./include/config.inc.php");

if(isset($HTTP_GET_VARS['final_uri'])){
    $final_uri = urldecode($HTTP_GET_VARS['final_uri']);
}

if (isset($HTTP_GET_VARS['msg'])) {
    $final_uri = "./discussion.php?msg=". $HTTP_GET_VARS['msg'];
}

if (isset($final_uri) && strstr($final_uri, 'logout.php')) {
    unset($final_uri);
}

if (bh_session_check()) {

    html_draw_top();
    echo "<div align=\"center\">\n";
    echo "<p>User ID ", bh_session_get_value('UID'), " already logged in.</p>\n";

    if (isset($final_uri)) {
        form_quick_button("./index.php", "Continue", "final_uri", urlencode($final_uri), "_top");
    }else {
        form_quick_button("./index.php", "Continue", "", "", "_top");
    }

    echo "</div>\n";
    html_draw_bottom();
    exit;

}

// Remove the cookie that makes this page show.

if (!isset($HTTP_COOKIE_VARS['bh_remember_username'])) {
    setcookie("bh_logon", "", time() - YEAR_IN_SECONDS);
}

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

// Delete the user's cookie as requested and send them back to the login form.

if (isset($HTTP_GET_VARS['deletecookie']) && $HTTP_GET_VARS['deletecookie'] == 'yes') {

  for ($i = 0; $i < sizeof($username_array); $i++) {

    setcookie("bh_remember_username[$i]", '', time() - YEAR_IN_SECONDS);
    setcookie("bh_remember_password[$i]", '', time() - YEAR_IN_SECONDS);
    setcookie("bh_remember_passhash[$i]", '', time() - YEAR_IN_SECONDS);

  }

  setcookie("bh_logon", "", time() - YEAR_IN_SECONDS);
  bh_session_end();

  if (isset($HTTP_SERVER_VARS['SERVER_SOFTWARE']) && !strstr($HTTP_SERVER_VARS['SERVER_SOFTWARE'], 'Microsoft-IIS')) {

    header_redirect("./index.php". (isset($final_uri) ? '?final_uri='. urlencode($final_uri) : ''));

  }else {

    html_draw_top();

    // Try a Javascript redirect
    echo "<script language=\"javascript\" type=\"text/javascript\">\n";
    echo "<!--\n";
    echo "document.location.href = './index.php", (isset($final_uri) ? '?final_uri='. urlencode($final_uri) : ''), "';\n";
    echo "//-->\n";
    echo "</script>";

    // If they're still here, Javascript's not working. Give up, give a link.
    echo "<div align=\"center\"><p>&nbsp;</p><p>&nbsp;</p>";
    echo "<p>You logged in successfully.</p>";

    if (isset($final_uri)) {
        form_quick_button("./index.php", "Continue", "final_uri", urlencode($final_uri), "_top");
    }else {
        form_quick_button("./index.php", "Continue", "", "", "_top");
    }

    html_draw_bottom();
    exit;

  }

}

if (isset($HTTP_POST_VARS['submit'])) {

  if(isset($HTTP_POST_VARS['logon']) && isset($HTTP_POST_VARS['password'])) {

    if (isset($HTTP_POST_VARS['savepass']) && ($HTTP_POST_VARS['savepass'] == true)) {

      if (($key = array_search($HTTP_POST_VARS['logon'], $username_array)) !== false) {

        if (isset($password_array[$key]) && $HTTP_POST_VARS['password'] == $password_array[$key]) {

          $luid = user_logon(strtoupper($HTTP_POST_VARS['logon']), $passhash_array[$key], true);

        }

      }

    }

    if (!isset($luid)) {

      $luid = user_logon(strtoupper($HTTP_POST_VARS['logon']), $HTTP_POST_VARS['password']);

    }

    if (isset($luid) && $luid > -1) {

      setcookie('bh_thread_mode', '', time() - YEAR_IN_SECONDS);

      if ((strtoupper($HTTP_POST_VARS['logon']) == 'GUEST') && (strtoupper($HTTP_POST_VARS['password']) == 'GUEST')) {

        if (user_guest_enabled() && $guest_account_enabled) {

          bh_session_init(0); // Use UID 0 for guest account.

        }

      }else {

        bh_session_init($luid);

        // Prepare Form Data

        $logon = _stripslashes($HTTP_POST_VARS['logon']);
        $passw = str_repeat(chr(32), strlen(_stripslashes($HTTP_POST_VARS['password'])));
        $passh = md5(_stripslashes($HTTP_POST_VARS['password']));

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

            if (isset($uncookie[0]) && isset($pwcookie[0]) && isset($phcookie[0])) {

              array_unshift($username_array, $uncookie[0]);

              if(isset($HTTP_POST_VARS['remember_user']) && ($HTTP_POST_VARS['remember_user'] == 'Y')) {
                if (isset($pwcookie[0]) && $pwcookie[0] == str_repeat(chr(255), 4)) {
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
        }

        // set / update the username and password cookies

        for ($i = 0; $i < sizeof($username_array); $i++) {

          setcookie("bh_remember_username[$i]", $username_array[$i], time() + YEAR_IN_SECONDS);
          setcookie("bh_remember_password[$i]", $password_array[$i], time() + YEAR_IN_SECONDS);
          setcookie("bh_remember_passhash[$i]", $passhash_array[$i], time() + YEAR_IN_SECONDS);

        }

        // set / update the cookie that remembers if the user
        // has any logon form data.

        setcookie("bh_logon", "1", time() + YEAR_IN_SECONDS);

      }

      // IIS bug prevents redirect at same time as setting cookies.

      if (isset($HTTP_SERVER_VARS['SERVER_SOFTWARE']) && !strstr($HTTP_SERVER_VARS['SERVER_SOFTWARE'], 'Microsoft-IIS')) {

          header_redirect("./index.php". (isset($final_uri) ? '?final_uri='. urlencode($final_uri) : ''));

      }else {

          html_draw_top();

          // Try a Javascript redirect
          echo "<script language=\"javascript\" type=\"text/javascript\">\n";
          echo "<!--\n";
          echo "document.location.href = './index.php", (isset($final_uri) ? '?final_uri='. urlencode($final_uri) : ''), "';\n";
          echo "//-->\n";
          echo "</script>";

          // If they're still here, Javascript's not working. Give up, give a link.
          echo "<div align=\"center\"><p>&nbsp;</p><p>&nbsp;</p>";
          echo "<p>You logged in successfully.</p>";

          if (isset($final_uri)) {
              form_quick_button("./index.php", "Continue", "final_uri", urlencode($final_uri), "_top");
          }else {
              form_quick_button("./index.php", "Continue", "", "", "_top");
          }

          html_draw_bottom();
          exit;

      }

    }else if(isset($luid) && $luid == -2){ // User is banned - everybody hide

        header("HTTP/1.0 500 Internal Server Error");
        exit;

    }else {

      html_draw_top();
      echo "<div align=\"center\">\n";
      echo "<h2>The username or password you supplied is not valid.</h2>\n";
      echo "<h2>Please reenter your password and try again.</h2>\n";
      echo form_quick_button("./index.php", "Back", 0, 0, "_top");
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
echo "  s = eval(\"document.logonform.savepass\"+ i +\".value\");\n";
echo "  document.logonform.logon.value = document.logonform.logonarray.options[i].value;\n";
echo "  if (s == false) {\n";
echo "    document.logonform.password.value = '';\n";
echo "    document.logonform.remember_user.checked = false;\n";
echo "    document.logonform.savepass.value = false\n";
echo "  }else {\n";
echo "    document.logonform.password.value = p;\n";
echo "    document.logonform.remember_user.checked = true;\n";
echo "    document.logonform.savepass.value = true\n";
echo "  }\n\n";
echo "}\n\n";
echo "var has_clicked = false;\n\n";
echo "//-->\n";
echo "</script>\n";

if (isset($error_html)) echo $error_html;

if (isset($HTTP_GET_VARS['other'])) {
  $otherlogon = true;
}else {
  $otherlogon = false;
}

echo "<p>&nbsp;</p>\n";
echo "<div align=\"center\">\n";
echo "  <form name=\"logonform\" action=\"". get_request_uri(). "\" method=\"post\" target=\"_top\" onsubmit=\"return has_clicked;\">\n";
echo "    <table class=\"box\" cellpadding=\"0\" cellspacing=\"0\">\n";
echo "      <tr>\n";
echo "        <td>\n";
echo "          <table class=\"subhead\" width=\"100%\">\n";
echo "            <tr>\n";
echo "              <td class=\"subhead\" align=\"left\">Logon</td>\n";
echo "            </tr>\n";
echo "          </table>\n";
echo "          <table class=\"posthead\" width=\"100%\">\n";

if ((sizeof($username_array) > 1) && $otherlogon == false) {

  echo "          <tr>\n";
  echo "            <td align=\"right\">User Name:</td>\n";
  echo "            <td>";

  foreach ($username_array as $key => $value) {
    $usernames[$key] = _stripslashes($value);
  }

  echo form_dropdown_array('logonarray', $usernames, $usernames, "", "onchange='changepassword()' style=\"width: 135px\"");
  echo form_input_hidden('logon', _stripslashes($username_array[0]));

  for ($i = 0; $i < sizeof($username_array); $i++) {

    if (isset($password_array[$i]) && isset($passhash_array[$i])) {

      if ($password_array[$i] == $passhash_array[$i]) {

        echo form_input_hidden('password'. $i, '');
        echo form_input_hidden('savepass'. $i, false);

      }else {

        echo form_input_hidden('password'. $i, $password_array[$i]);
        echo form_input_hidden('savepass'. $i, true);

      }

    }else {

      echo form_input_hidden('password'. $i, '');
      echo form_input_hidden('savepass'. $i, false);

    }

  }

  $request_uri = get_request_uri();

  if (strstr($request_uri, '?')) {
    $request_uri.= "&other=true";
  }else {
    $request_uri.= "?other=true";
  }

  echo "&nbsp;", form_button("other", "Other", "onclick=\"self.location.href='". $request_uri. "';\""), "</td>\n";

  echo "          </tr>\n";
  echo "          <tr>\n";
  echo "            <td align=\"right\">Password:</td>\n";
  echo "            <td>";

  if (isset($password_array[0]) && isset($passhash_array[0])) {

    if ($password_array[0] == $passhash_array[0]) {

      echo form_input_password('password', '');

    }else {

      echo form_input_password('password', $password_array[0]);
      echo form_input_hidden('savepass', true);

    }

  }else {

    echo form_input_password('password'. $i, '');

  }

  echo "</td>\n";
  echo "          </tr>\n";

}else {

  echo "          <tr>\n";
  echo "            <td align=\"right\">User Name:</td>\n";
  echo "            <td>", form_input_text('logon', isset($username_array[0]) && $otherlogon == false ? _stripslashes($username_array[0]) : ''), "</td>\n";
  echo "          </tr>\n";
  echo "          <tr>\n";
  echo "            <td align=\"right\">Password:</td>\n";
  echo "            <td>";

  if (isset($password_array[0]) && isset($passhash_array[0]) && $otherlogon == false) {

    if ($password_array[0] == $passhash_array[0]) {

      echo form_input_password('password', '');

    }else {

      echo form_input_password('password', $password_array[0]);
      echo form_input_hidden('savepass', true);

    }

  }else {

    echo form_input_password('password', '');

  }

  echo "</td>\n";
  echo "          </tr>\n";

}

echo "            <tr>\n";
echo "              <td>&nbsp;</td>\n";
echo "              <td>";

echo form_checkbox("remember_user", "Y", "Remember passwords", (isset($password_array[0]) && $password_array[0] != str_repeat(chr(255), 4)) && strlen($password_array[0]) > 0 && $otherlogon == false);

echo "</td>\n";
echo "            </tr>\n";
echo "          </table>\n";
echo "          <table class=\"posthead\" width=\"100%\">\n";
echo "            <tr>\n";
echo "              <td align=\"center\">";

echo form_submit('submit', 'Logon', 'onclick="has_clicked = true"');

echo "</td>\n";
echo "            </tr>\n";
echo "          </table>\n";
echo "        </td>\n";
echo "      </tr>\n";
echo "    </table>\n";
echo "  </form>\n";

if (user_guest_enabled() && $guest_account_enabled) {

  echo "  <form name=\"guest\" action=\"", get_request_uri(), "\" method=\"POST\" target=\"_top\">\n";
  echo "    <p class=\"smalltext\">Enter as a ". form_input_hidden("logon", "guest"). form_input_hidden("password", "guest"). form_submit("submit", "Guest"). "</p>\n";
  echo "  </form>\n";

}

echo "  <p class=\"smalltext\">Don't have an account? <a href=\"register.php", (isset($final_uri) ? '?final_uri='. urlencode($final_uri) : ''), "\" target=\"_self\">Register now.</a></p>\n";
echo "  <hr width=\"350\" />\n";
echo "  <h2>Problems logging on?</h2>\n";
echo "  <p class=\"smalltext\"><a href=\"logon.php?deletecookie=yes", (isset($final_uri) ? '&final_uri='. urlencode($final_uri) : ''), "\" target=\"_top\">Delete Cookies</a></p>\n";
echo "  <p class=\"smalltext\"><a href=\"forgot_pw.php", (isset($final_uri) ? '?final_uri='. urlencode($final_uri) : ''), "\" target=\"_self\">Forgotten your password?</a></p>\n";
echo "  <hr width=\"350\" />\n";
echo "  <h2>Using a PDA?</h2>\n";
echo "  <p class=\"smalltext\"><a href=\"llogon.php\" target=\"_top\">Light HTML version</a></p>\n";
echo "</div>\n";

html_draw_bottom();

?>