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

/* $Id: index.php,v 1.57 2004-03-10 18:43:17 decoyduck Exp $ */

//Multiple forum support
require_once("./include/forum.inc.php");

// Compress the output
require_once("./include/gzipenc.inc.php");

// Enable the error handler
require_once("./include/errorhandler.inc.php");

// Main page
// Disable caching when showing logon page
require_once("./include/header.inc.php");
require_once("./include/messages.inc.php");
require_once("./include/session.inc.php");
require_once("./include/config.inc.php");
require_once("./include/lang.inc.php");

if (!isset($auto_logon)) $auto_logon = true;

header_no_cache();

if (!isset($HTTP_COOKIE_VARS['bh_remember_username'])) {
    bh_setcookie("bh_logon", "", time() - YEAR_IN_SECONDS);
}

if (!isset($default_style)) $default_style = "default";
if (!isset($guest_account_enabled)) $guest_account_enabled = true;

$top_html   = "styles/". (bh_session_get_value('STYLE') ? bh_session_get_value('STYLE') : $default_style). "/top.html";
$stylesheet = "styles/". (bh_session_get_value('STYLE') ? bh_session_get_value('STYLE') : $default_style). "/style.css";

if (!file_exists($top_html)) {
    $top_html = "./top.html";
}

if (!isset($forum_name)) $forum_name = "A Beehive Forum";

echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Frameset//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd\">\n";
echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\" dir=\"{$lang['_textdir']}\">\n";
echo "<head>\n";
echo "<title>{$forum_name}</title>\n";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset={$lang['_charset']}\">\n";
echo "<link rel=\"stylesheet\" href=\"{$stylesheet}\" type=\"text/css\" />\n";
echo "<link rel=\"icon\" href=\"images/favicon.ico\" type=\"image/ico\">\n";
echo "</head>\n";

if (isset($HTTP_GET_VARS['autologon']) && $HTTP_GET_VARS['autologon'] == 0) {
    bh_session_end();
    $auto_logon = false;
}

if (bh_session_check()) {

    // User is actually logged in. Show them the relevant frameset.

    // Calculate how tall the nav frameset should be based on the user's fontsize.
    
    $navsize = bh_session_get_value('FONT_SIZE');
    $navsize = ($navsize) ? $navsize * 2 : 20;

    echo "<frameset rows=\"60,$navsize,*\" frameborder=\"0\" framespacing=\"0\">\n";
    echo "<frame src=\"". $top_html. "\" name=\"ftop\" frameborder=\"0\" framespacing=\"0\" scrolling=\"no\" marginwidth=\"0\" marginheight=\"0\" noresize=\"noresize\" />\n";
    echo "<frame src=\"./nav.php?webtag=$webtag\" name=\"fnav\" frameborder=\"0\" framespacing=\"0\" scrolling=\"no\" marginwidth=\"0\" marginheight=\"0\" noresize=\"noresize\" />\n";

    if (isset($HTTP_GET_VARS['final_uri'])) {

      echo "<frame src=\"". urldecode($HTTP_GET_VARS['final_uri']). "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

    }else if (isset($HTTP_GET_VARS['msg']) && validate_msg($HTTP_GET_VARS['msg'])) {

      echo "<frame src=\"./discussion.php?webtag=$webtag&msg=". $HTTP_GET_VARS['msg']. "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

    }else if (isset($HTTP_GET_VARS['folder']) && is_numeric($HTTP_GET_VARS['folder'])) {

      echo "<frame src=\"./discussion.php?webtag=$webtag&folder=". $HTTP_GET_VARS['folder']. "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

    }else if (isset($HTTP_GET_VARS['pmid']) && is_numeric($HTTP_GET_VARS['pmid'])) {

      echo "<frame src=\"./pm.php?webtag=$webtag&mid=". $HTTP_GET_VARS['pmid']. "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

    }else {

      $user_prefs = user_get_prefs(bh_session_get_value('UID'));

      if (isset($user_prefs['START_PAGE']) && $user_prefs['START_PAGE'] == 1) {
        $final_uri = "./discussion.php?webtag=$webtag";
      }elseif (isset($user_prefs['START_PAGE']) && $user_prefs['START_PAGE'] == 2) {
        $final_uri = "./pm.php?webtag=$webtag";
      }else {
        $final_uri = "./start.php?webtag=$webtag";
      }

      echo "<frame src=\"", $final_uri, "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

    }

}else {

    // Check to see if the user has visited before and logged in.

    if (!isset($HTTP_COOKIE_VARS['bh_logon']) && user_guest_enabled() && $guest_account_enabled && $auto_logon) {

        bh_session_init(0); // auto login as guest

        echo "<frameset rows=\"60,20,*\" frameborder=\"0\" framespacing=\"0\">\n";
        echo "<frame src=\"". $top_html. "\" name=\"top\" frameborder=\"0\" framespacing=\"0\" scrolling=\"no\" marginwidth=\"0\" marginheight=\"0\" noresize=\"noresize\" />\n";
        echo "<frame src=\"./nav.php?webtag=$webtag\" name=\"fnav\" frameborder=\"0\" framespacing=\"0\" scrolling=\"no\" marginwidth=\"0\" marginheight=\"0\" noresize=\"noresize\" />\n";

        if (isset($HTTP_GET_VARS['final_uri'])) {

            echo "<frame src=\"", urldecode($HTTP_GET_VARS['final_uri']), "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

        }elseif(isset($HTTP_GET_VARS['msg']) && validate_msg($HTTP_GET_VARS['msg'])) {

            echo "<frame src=\"discussion.php?webtag=$webtag&msg=", $HTTP_GET_VARS['msg'], "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

        }else if (isset($HTTP_GET_VARS['folder'])) {

            echo "<frame src=\"discussion.php?webtag=$webtag&folder=", $HTTP_GET_VARS['folder'], "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

        }else if (isset($HTTP_GET_VARS['pmid'])) {

            echo "<frame src=\"./pm.php?webtag=$webtag&mid=", $HTTP_GET_VARS['pmid'], "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

        }else {

            echo "<frame src=\"./start.php?webtag=$webtag\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

        }

    }else {

        echo "<frameset rows=\"60,*\" frameborder=\"0\" framespacing=\"0\">\n";
        echo "<frame src=\"". $top_html. "\" name=\"top\" frameborder=\"0\" framespacing=\"0\" scrolling=\"no\" marginwidth=\"0\" marginheight=\"0\" noresize=\"noresize\" />\n";

        if (isset($HTTP_GET_VARS['final_uri'])) {

            echo "<frame src=\"./logon.php?webtag=$webtag&final_uri=". $HTTP_GET_VARS['final_uri']. "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

        }elseif(isset($HTTP_GET_VARS['msg']) && validate_msg($HTTP_GET_VARS['msg'])) {

            echo "<frame src=\"./logon.php?webtag=$webtag&final_uri=". urlencode("./discussion.php?webtag=$webtag&msg=". $HTTP_GET_VARS['msg']). "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

        }else if (isset($HTTP_GET_VARS['folder']) && is_numeric($HTTP_GET_VARS['folder'])) {

            echo "<frame src=\"./logon.php?webtag=$webtag&final_uri=". urlencode("./discussion.php?webtag=$webtag&folder=". $HTTP_GET_VARS['folder']). "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

        }else if (isset($HTTP_GET_VARS['pmid']) && is_numeric($HTTP_GET_VARS['pmid'])) {

            echo "<frame src=\"./logon.php?webtag=$webtag&final_uri=". urlencode("./pm.php?webtag=$webtag&mid=". $HTTP_GET_VARS['pmid']). "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

        }else {

            echo "<frame src=\"./logon.php?webtag=$webtag\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

        }
    }
}

?>
<noframes>
<body>
<h1><?php echo $lang['noframessupport']; ?></h1>
<p><?php echo $lang['uselightversion']; ?></p>
</body>
</noframes>
</frameset>
</html>