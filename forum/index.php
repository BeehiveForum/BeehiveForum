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

// Main page
// Disable caching when showing logon page
require_once("./include/header.inc.php");
require_once("./include/session.inc.php");
require_once("./include/config.inc.php");
require_once("./include/lang.inc.php");

header_no_cache();

if (!isset($HTTP_COOKIE_VARS['bh_remember_username'])) {
    setcookie("bh_logon", "", time() - YEAR_IN_SECONDS);
}

$top_html   = "styles/". (bh_session_get_value('STYLE') ? bh_session_get_value('STYLE') : $default_style). "/top.html";
$stylesheet = "styles/". (bh_session_get_value('STYLE') ? bh_session_get_value('STYLE') : $default_style). "/style.css";

if (!file_exists($top_html)) {
    $top_html = "./top.html";
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="<?php echo $lang['_textdir']; ?>">
<head>
<title><?php echo $forum_name; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $lang['_charset']; ?>">
<link rel="stylesheet" href="<?php echo $stylesheet; ?>" type="text/css" />
</head>
<?php

if (isset($HTTP_GET_VARS['autologon']) && $HTTP_GET_VARS['autologon'] == 0) {
    bh_session_end();
    $auto_logon = false;
}

if (bh_session_check()) {

    // User is actually logged in. Show them the relevant frameset.

    echo "<frameset rows=\"60,20,*\" frameborder=\"0\" framespacing=\"0\">\n";
    echo "<frame src=\"". $top_html. "\" name=\"ftop\" frameborder=\"0\" framespacing=\"0\" scrolling=\"no\" marginwidth=\"0\" marginheight=\"0\" noresize=\"noresize\" />\n";
    echo "<frame src=\"./nav.php\" name=\"fnav\" frameborder=\"0\" framespacing=\"0\" scrolling=\"no\" marginwidth=\"0\" marginheight=\"0\" noresize=\"noresize\" />\n";

    if (isset($HTTP_GET_VARS['final_uri'])) {

      echo "<frame src=\"". urldecode($HTTP_GET_VARS['final_uri']). "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

    }else if (isset($HTTP_GET_VARS['msg'])) {

      echo "<frame src=\"./discussion.php?msg=". $HTTP_GET_VARS['msg']. "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

    }else if (isset($HTTP_GET_VARS['folder'])) {

      echo "<frame src=\"./discussion.php?folder=". $HTTP_GET_VARS['folder']. "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

    }else if (isset($HTTP_GET_VARS['pmid'])) {

      echo "<frame src=\"./pm.php?mid=". $HTTP_GET_VARS['pmid']. "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

    }else {

      $user_prefs = user_get_prefs(bh_session_get_value('UID'));

      if (isset($user_prefs['START_PAGE']) && $user_prefs['START_PAGE'] == 1) {
        $final_uri = "./discussion.php";
      }elseif (isset($user_prefs['START_PAGE']) && $user_prefs['START_PAGE'] == 2) {
        $final_uri = "./pm.php";
      }else {
        $final_uri = "./start.php";
      }

      echo "<frame src=\"", $final_uri, "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

    }

}else {

    // Check to see if the user has visited before and logged in.

    if (!isset($HTTP_COOKIE_VARS['bh_logon']) && user_guest_enabled() && $guest_account_enabled && $auto_logon) {

        bh_session_init(0); // auto login as guest

        echo "<frameset rows=\"60,20,*\" frameborder=\"0\" framespacing=\"0\">\n";
        echo "<frame src=\"". $top_html. "\" name=\"top\" frameborder=\"0\" framespacing=\"0\" scrolling=\"no\" marginwidth=\"0\" marginheight=\"0\" noresize=\"noresize\" />\n";
        echo "<frame src=\"./nav.php\" name=\"fnav\" frameborder=\"0\" framespacing=\"0\" scrolling=\"no\" marginwidth=\"0\" marginheight=\"0\" noresize=\"noresize\" />\n";

        if (isset($HTTP_GET_VARS['final_uri'])) {

            echo "<frame src=\"./logon.php?final_uri=". $HTTP_GET_VARS['final_uri']. "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

        }elseif(isset($HTTP_GET_VARS['msg'])) {

            echo "<frame src=\"./logon.php?final_uri=". urlencode("./discussion.php?msg=". $HTTP_GET_VARS['msg']). "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

        }else if (isset($HTTP_GET_VARS['folder'])) {

            echo "<frame src=\"./logon.php?final_uri=". urlencode("./discussion.php?folder=". $HTTP_GET_VARS['folder']). "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

        }else if (isset($HTTP_GET_VARS['pmid'])) {

            echo "<frame src=\"./logon.php?final_uri=". urlencode("./pm.php?mid=". $HTTP_GET_VARS['pmid']). "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

        }else {

            echo "<frame src=\"./logon.php\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

        }

    }else {

        echo "<frameset rows=\"60,*\" frameborder=\"0\" framespacing=\"0\">\n";
        echo "<frame src=\"". $top_html. "\" name=\"top\" frameborder=\"0\" framespacing=\"0\" scrolling=\"no\" marginwidth=\"0\" marginheight=\"0\" noresize=\"noresize\" />\n";

        if (isset($HTTP_GET_VARS['final_uri'])) {

            echo "<frame src=\"./logon.php?final_uri=". $HTTP_GET_VARS['final_uri']. "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

        }elseif(isset($HTTP_GET_VARS['msg'])) {

            echo "<frame src=\"./logon.php?final_uri=". urlencode("./discussion.php?msg=". $HTTP_GET_VARS['msg']). "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

        }else if (isset($HTTP_GET_VARS['folder'])) {

            echo "<frame src=\"./logon.php?final_uri=". urlencode("./discussion.php?folder=". $HTTP_GET_VARS['folder']). "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

        }else if (isset($HTTP_GET_VARS['pmid'])) {

            echo "<frame src=\"./logon.php?final_uri=". urlencode("./pm.php?mid=". $HTTP_GET_VARS['pmid']). "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

        }else {

            echo "<frame src=\"./logon.php\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

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