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
require_once("./include/light.inc.php");

if(isset($HTTP_GET_VARS['final_uri'])){
    $final_uri = urldecode($HTTP_GET_VARS['final_uri']);
}else {
    $final_uri = "./lthread_list.php";
}

if(bh_session_check()) {

    light_html_draw_top();
    echo "<p>User ID ", $HTTP_COOKIE_VARS['bh_sess_uid'], " already logged in.</p>\n";
    echo form_quick_button("./lthread_list.php", "Continue", 0, 0, "_top");
    light_html_draw_bottom();
    exit;

}

if (isset($HTTP_POST_VARS['submit'])) {

  if(isset($HTTP_POST_VARS['logon']) && isset($HTTP_POST_VARS['password'])) {

    $luid = user_logon(strtoupper($HTTP_POST_VARS['logon']), $HTTP_POST_VARS['password']);

    if ($luid > -1) {

      setcookie('bh_thread_mode', '', time() - YEAR_IN_SECONDS, dirname($HTTP_SERVER_VARS['PHP_SELF']). '/');

      if ((strtoupper($HTTP_POST_VARS['logon']) == 'GUEST') && (strtoupper($HTTP_POST_VARS['password']) == 'GUEST')) {

        bh_session_init(0); // Use UID 0 for guest account.

      }else {

        bh_session_init($luid);

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

	if (!is_array($usernames)) $usernames = array();
	if (!is_array($passwords)) $passwords = array();

        if (!in_array($HTTP_POST_VARS['logon'], $usernames)) {

          array_unshift($usernames, $HTTP_POST_VARS['logon']);

	  if(isset($HTTP_POST_VARS['remember_user'])) {
	    array_unshift($passwords, $HTTP_POST_VARS['password']);
	  }else {
	    array_unshift($passwords, str_repeat(chr(255), 4));
	  }

        }else {

	  if (($key = array_search($HTTP_POST_VARS['logon'], $usernames)) !== false) {

	    array_splice($usernames, $key, 1);
	    array_splice($passwords, $key, 1);

            array_unshift($usernames, $HTTP_POST_VARS['logon']);

            if(isset($HTTP_POST_VARS['remember_user'])) {
	      array_unshift($passwords, $HTTP_POST_VARS['password']);
	    }else {
	      array_unshift($passwords, str_repeat(chr(255), 4));
	    }

	  }

	}

        for ($i = 0; $i < sizeof($usernames); $i++) {

          setcookie("bh_remember_user[$i]", _stripslashes($usernames[$i]), time() + YEAR_IN_SECONDS, dirname($HTTP_SERVER_VARS['PHP_SELF']). '/');
          setcookie("bh_remember_password[$i]", _stripslashes($passwords[$i]), time() + YEAR_IN_SECONDS, dirname($HTTP_SERVER_VARS['PHP_SELF']). '/');

        }

      }

      if (!strstr(@$HTTP_SERVER_VARS['SERVER_SOFTWARE'], 'Microsoft-IIS')) { // Not IIS

          header_redirect("./lthread_list.php");

      }else { // IIS bug prevents redirect at same time as setting cookies.

          light_html_draw_top();

          echo "<p>You logged in successfully.</p>";
          echo form_quick_button("./index.php", "Continue", "final_uri", urlencode($final_uri));

          light_html_draw_bottom();
          exit;

      }

    }else if($luid == -2){ // User is banned - everybody hide

        header("HTTP/1.0 500 Internal Server Error");
        exit;

    }else {

      light_html_draw_top();
      echo "<h2>The username or password you supplied is not valid.</h2>\n";
      echo form_quick_button("./index.php", "Back", 0, 0, "_top");
      light_html_draw_bottom();
      exit;

    }

  }else {

    $error_html = "<h2>A username and password is required</h2>";
  }

}

light_html_draw_top();

if (isset($error_html)) echo $error_html;

echo "<p>Welcome to Diet Beehive!</p>\n";
echo "  <form name=\"logonform\" action=\"". get_request_uri() ."\" method=\"POST\">\n";

echo "<p>User Name: ";
echo light_form_input_text("logon"). "</p>\n";

echo "<p>Password: ";
echo light_form_input_password("password"). "</p>\n";

echo "<p>".form_submit('submit', 'Logon')."</p>\n";

echo "  </form>\n";


light_html_draw_bottom();

?>
