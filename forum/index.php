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

/* $Id: index.php,v 1.67 2004-03-22 13:27:21 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

//Multiple forum support
include_once("./include/forum.inc.php");

// Fetch the forum webtag and settings
$webtag = get_webtag();
$forum_settings = get_forum_settings();

include_once("./include/config.inc.php");
include_once("./include/header.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/messages.inc.php");
include_once("./include/session.inc.php");

header_no_cache();

if (!isset($HTTP_COOKIE_VARS['bh_remember_username'])) {
    bh_setcookie("bh_logon", "", time() - YEAR_IN_SECONDS);
}

$auto_logon = forum_get_setting('auto_logon', 'Y', false);

$top_html   = "styles/". (bh_session_get_value('STYLE') ? bh_session_get_value('STYLE') : forum_get_setting('default_style')). "/top.html";
$stylesheet = "styles/". (bh_session_get_value('STYLE') ? bh_session_get_value('STYLE') : forum_get_setting('default_style')). "/style.css";

if (!file_exists($top_html)) {
    $top_html = "./top.html";
}

echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Frameset//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd\">\n";
echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\" dir=\"{$lang['_textdir']}\">\n";
echo "<head>\n";
echo "<title>", forum_get_setting('forum_name', false, 'A Beehive Forum'), "</title>\n";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset={$lang['_charset']}\">\n";
echo "<link rel=\"stylesheet\" href=\"{$stylesheet}\" type=\"text/css\" />\n";
echo "<link rel=\"icon\" href=\"images/favicon.ico\" type=\"image/ico\">\n";
echo "</head>\n";

if (isset($HTTP_GET_VARS['autologon']) && $HTTP_GET_VARS['autologon'] == 0) {
    bh_session_end();
    $auto_logon = false;
}

if ($user_sess = bh_session_check()) {

    // User is actually logged in. Show them the relevant frameset.

    // Calculate how tall the nav frameset should be based on the user's fontsize.
    
    $navsize = bh_session_get_value('FONT_SIZE');
    $navsize = ($navsize) ? $navsize * 2 : 20;

    echo "<frameset rows=\"60,$navsize,*\" frameborder=\"0\" framespacing=\"0\">\n";
    echo "<frame src=\"". $top_html. "\" name=\"ftop\" frameborder=\"0\" framespacing=\"0\" scrolling=\"no\" marginwidth=\"0\" marginheight=\"0\" noresize=\"noresize\" />\n";
    echo "<frame src=\"./nav.php?webtag={$webtag['WEBTAG']}\" name=\"fnav\" frameborder=\"0\" framespacing=\"0\" scrolling=\"no\" marginwidth=\"0\" marginheight=\"0\" noresize=\"noresize\" />\n";

    if (isset($HTTP_GET_VARS['final_uri'])) {

      echo "<frame src=\"". rawurldecode($HTTP_GET_VARS['final_uri']). "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

    }else if (isset($HTTP_GET_VARS['msg']) && validate_msg($HTTP_GET_VARS['msg'])) {

      echo "<frame src=\"./discussion.php?webtag={$webtag['WEBTAG']}&msg=". $HTTP_GET_VARS['msg']. "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

    }else if (isset($HTTP_GET_VARS['folder']) && is_numeric($HTTP_GET_VARS['folder'])) {

      echo "<frame src=\"./discussion.php?webtag={$webtag['WEBTAG']}&folder=". $HTTP_GET_VARS['folder']. "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

    }else if (isset($HTTP_GET_VARS['pmid']) && is_numeric($HTTP_GET_VARS['pmid'])) {

      echo "<frame src=\"./pm.php?webtag={$webtag['WEBTAG']}&mid=". $HTTP_GET_VARS['pmid']. "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

    }else {

      $user_prefs = user_get_prefs(bh_session_get_value('UID'));

      if (isset($user_prefs['START_PAGE']) && $user_prefs['START_PAGE'] == 1) {
        $final_uri = "./discussion.php?webtag={$webtag['WEBTAG']}";
      }elseif (isset($user_prefs['START_PAGE']) && $user_prefs['START_PAGE'] == 2) {
        $final_uri = "./pm.php?webtag={$webtag['WEBTAG']}";
      }else {
        $final_uri = "./start.php?webtag={$webtag['WEBTAG']}";
      }

      echo "<frame src=\"", $final_uri, "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

    }

}else {

    // Check to see if the user has visited before and logged in.

    if (!isset($HTTP_COOKIE_VARS['bh_logon']) && user_guest_enabled() && $auto_logon) {

        bh_session_init(0); // auto login as guest

        echo "<frameset rows=\"60,20,*\" frameborder=\"0\" framespacing=\"0\">\n";
        echo "<frame src=\"". $top_html. "\" name=\"top\" frameborder=\"0\" framespacing=\"0\" scrolling=\"no\" marginwidth=\"0\" marginheight=\"0\" noresize=\"noresize\" />\n";
        echo "<frame src=\"./nav.php?webtag={$webtag['WEBTAG']}\" name=\"fnav\" frameborder=\"0\" framespacing=\"0\" scrolling=\"no\" marginwidth=\"0\" marginheight=\"0\" noresize=\"noresize\" />\n";

        if (isset($HTTP_GET_VARS['final_uri'])) {

            echo "<frame src=\"", rawurldecode($HTTP_GET_VARS['final_uri']), "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

        }elseif (isset($HTTP_GET_VARS['msg']) && validate_msg($HTTP_GET_VARS['msg'])) {

            echo "<frame src=\"discussion.php?webtag={$webtag['WEBTAG']}&msg=", $HTTP_GET_VARS['msg'], "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

        }else if (isset($HTTP_GET_VARS['folder'])) {

            echo "<frame src=\"discussion.php?webtag={$webtag['WEBTAG']}&folder=", $HTTP_GET_VARS['folder'], "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

        }else if (isset($HTTP_GET_VARS['pmid'])) {

            echo "<frame src=\"./pm.php?webtag={$webtag['WEBTAG']}&mid=", $HTTP_GET_VARS['pmid'], "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

        }else {

            echo "<frame src=\"./start.php?webtag={$webtag['WEBTAG']}\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

        }

    }else {

        echo "<frameset rows=\"60,*\" frameborder=\"0\" framespacing=\"0\">\n";
        echo "<frame src=\"". $top_html. "\" name=\"top\" frameborder=\"0\" framespacing=\"0\" scrolling=\"no\" marginwidth=\"0\" marginheight=\"0\" noresize=\"noresize\" />\n";

        if (isset($HTTP_GET_VARS['final_uri'])) {

            echo "<frame src=\"./logon.php?webtag={$webtag['WEBTAG']}&final_uri=", rawurlencode($HTTP_GET_VARS['final_uri']), "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

        }elseif (isset($HTTP_GET_VARS['msg']) && validate_msg($HTTP_GET_VARS['msg'])) {

            echo "<frame src=\"./logon.php?webtag={$webtag['WEBTAG']}&final_uri=". rawurlencode("./discussion.php?webtag={$webtag['WEBTAG']}&msg=". $HTTP_GET_VARS['msg']). "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

        }else if (isset($HTTP_GET_VARS['folder']) && is_numeric($HTTP_GET_VARS['folder'])) {

            echo "<frame src=\"./logon.php?webtag={$webtag['WEBTAG']}&final_uri=". rawurlencode("./discussion.php?webtag={$webtag['WEBTAG']}&folder=". $HTTP_GET_VARS['folder']). "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

        }else if (isset($HTTP_GET_VARS['pmid']) && is_numeric($HTTP_GET_VARS['pmid'])) {

            echo "<frame src=\"./logon.php?webtag={$webtag['WEBTAG']}&final_uri=". rawurlencode("./pm.php?webtag={$webtag['WEBTAG']}&mid=". $HTTP_GET_VARS['pmid']). "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

        }else {

            echo "<frame src=\"./logon.php?webtag={$webtag['WEBTAG']}\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

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