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

/* $Id: llogon.php,v 1.27 2004-04-04 21:03:39 decoyduck Exp $ */

// Light Mode Detection
define("BEEHIVEMODE_LIGHT", true);

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Multiple forum support
include_once("./include/forum.inc.php");

// Fetch the forum webtag and settings
$webtag = get_webtag();
$forum_settings = get_forum_settings();

include_once("./include/beehive.inc.php");
include_once("./include/constants.inc.php");
include_once("./include/form.inc.php");
include_once("./include/format.inc.php");
include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/light.inc.php");
include_once("./include/session.inc.php");
include_once("./include/user.inc.php");

if (isset($HTTP_GET_VARS['final_uri'])) {
    $final_uri = rawurldecode($HTTP_GET_VARS['final_uri']);
}else {
    $final_uri = "./lthread_list.php?webtag=$webtag";
}

if ($user_sess = bh_session_check() && bh_session_get_value('UID') != 0) {

    light_html_draw_top();
    echo "<p>{$lang['user']} ", bh_session_get_value('LOGON'), " {$lang['alreadyloggedin']}.</p>\n";
    form_quick_button("./lthread_list.php", $lang['continue'], false, false, "_top");
    light_html_draw_bottom();
    exit;

}

if (isset($HTTP_POST_VARS['submit'])) {

  if (isset($HTTP_POST_VARS['logon']) && isset($HTTP_POST_VARS['password'])) {

    $luid = user_logon(strtoupper($HTTP_POST_VARS['logon']), $HTTP_POST_VARS['password']);

    if ($luid > -1) {

      bh_setcookie('bh_thread_mode', '', time() - YEAR_IN_SECONDS);

      if ((strtoupper($HTTP_POST_VARS['logon']) == 'GUEST') && (strtoupper($HTTP_POST_VARS['password']) == 'GUEST')) {

        bh_session_init(0); // Use UID 0 for guest account.

      }else {

        bh_session_init($luid);

      }
      
      if (isset($HTTP_POST_VARS['remember_user']) && $HTTP_POST_VARS['remember_user'] == 'Y') {
      
          bh_setcookie("bh_light_remember_username", $HTTP_POST_VARS['logon'], time() + YEAR_IN_SECONDS);
	  bh_setcookie("bh_light_remember_password", $HTTP_POST_VARS['password'], time() + YEAR_IN_SECONDS);
      }

      if (!strstr(@$HTTP_SERVER_VARS['SERVER_SOFTWARE'], 'Microsoft-IIS')) { // Not IIS

          header_redirect("./lthread_list.php?webtag=$webtag");

      }else { // IIS bug prevents redirect at same time as setting cookies.

          light_html_draw_top();

          echo "<p>{$lang['loggedinsuccessfully']}</p>";
          form_quick_button("./index.php", $lang['continue'], "final_uri", rawurlencode($final_uri));

          light_html_draw_bottom();
          exit;

      }

    }else if ($luid == -2) { // User is banned - everybody hide

        if (!strstr(php_sapi_name(), 'cgi')) {
            header("HTTP/1.0 500 Internal Server Error");
        }else {
            echo "<h1>HTTP/1.0 500 Internal Server Error</h1>\n";
        }

        exit;

    }else {

        light_html_draw_top();
        echo "<h2>{$lang['usernameorpasswdnotvalid']}</h2>\n";
        form_quick_button("./index.php", $lang['back'], false, false, "_top");
        light_html_draw_bottom();
        exit;
    }

  }else {

    $error_html = "<h2>{$lang['usernameandpasswdrequired']}</h2>";
  }

}

light_html_draw_top();

if (isset($error_html)) echo $error_html;

echo "<p>{$lang['welcometolight']}</p>\n";
echo "  <form name=\"logonform\" action=\"". get_request_uri() ."\" method=\"POST\">\n";

echo "<p>{$lang['username']}: ";
echo light_form_input_text("logon", (isset($HTTP_COOKIE_VARS['bh_light_remember_username']) ? $HTTP_COOKIE_VARS['bh_light_remember_username'] : "")). "</p>\n";

echo "<p>{$lang['passwd']}: ";
echo light_form_input_password("password", (isset($HTTP_COOKIE_VARS['bh_light_remember_password']) ? $HTTP_COOKIE_VARS['bh_light_remember_password'] : "")). "</p>\n";

echo "<p>", form_checkbox("remember_user", "Y", $lang['rememberpassword'], (isset($HTTP_COOKIE_VARS['bh_light_remember_username']) && isset($HTTP_COOKIE_VARS['bh_light_remember_password']) ? true : false)), "</p>\n";

echo "<p>", form_submit('submit', $lang['logon']), "</p>\n";

echo "  </form>\n";

light_html_draw_bottom();

?>