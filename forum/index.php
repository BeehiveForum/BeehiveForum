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

/* $Id: index.php,v 1.80 2004-04-24 18:48:02 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

//Multiple forum support
include_once("./include/forum.inc.php");

$forum_settings = get_forum_settings();

include_once("./include/header.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/logon.inc.php");
include_once("./include/messages.inc.php");
include_once("./include/session.inc.php");

if (!isset($_COOKIE['bh_remember_username'])) {
    bh_setcookie("bh_logon", "", time() - YEAR_IN_SECONDS);
}

$auto_logon = forum_get_setting('auto_logon', 'Y', false);

$top_html   = "styles/". (bh_session_get_value('STYLE') ? bh_session_get_value('STYLE') : forum_get_setting('default_style')). "/top.html";
$stylesheet = "styles/". (bh_session_get_value('STYLE') ? bh_session_get_value('STYLE') : forum_get_setting('default_style')). "/style.css";

if (!file_exists($top_html)) {
    $top_html = "./top.html";
}

if (isset($_GET['autologon']) && $_GET['autologon'] == 0) {
    bh_session_end();
    $auto_logon = false;
}

if ($user_sess = bh_session_check()) {

    // User is actually logged in. Show them the relevant frameset.

    // Load language file

    $lang = load_language_file();

    // Fetch the forum settings

    $webtag = get_webtag();

    // Calculate how tall the nav frameset should be based on the user's fontsize.

    $navsize = bh_session_get_value('FONT_SIZE');
    $navsize = ($navsize) ? $navsize * 2 : 20;

    echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Frameset//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd\">\n";
    echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\" dir=\"{$lang['_textdir']}\">\n";
    echo "<head>\n";
    echo "<title>", forum_get_setting('forum_name', false, 'A Beehive Forum'), "</title>\n";
    echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset={$lang['_charset']}\">\n";
    echo "<link rel=\"stylesheet\" href=\"{$stylesheet}\" type=\"text/css\" />\n";
    echo "<link rel=\"icon\" href=\"images/favicon.ico\" type=\"image/ico\">\n";
    echo "</head>\n";

    echo "<frameset rows=\"60,$navsize,*\" frameborder=\"0\" framespacing=\"0\">\n";
    echo "<frame src=\"". $top_html. "\" name=\"ftop\" frameborder=\"0\" framespacing=\"0\" scrolling=\"no\" marginwidth=\"0\" marginheight=\"0\" noresize=\"noresize\" />\n";
    echo "<frame src=\"./nav.php?webtag=$webtag\" name=\"fnav\" frameborder=\"0\" framespacing=\"0\" scrolling=\"no\" marginwidth=\"0\" marginheight=\"0\" noresize=\"noresize\" />\n";

    if ($webtag) {

        if (isset($_GET['final_uri'])) {

	    if (stristr(rawurldecode($_GET['final_uri']), "?")) {
                echo "<frame src=\"". rawurldecode($_GET['final_uri']). "&webtag=$webtag\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";
	    }else {
                echo "<frame src=\"". rawurldecode($_GET['final_uri']). "?webtag=$webtag\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";
	    }

        }else if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

            echo "<frame src=\"./discussion.php?webtag=$webtag&msg=". $_GET['msg']. "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

        }else if (isset($_GET['folder']) && is_numeric($_GET['folder'])) {

            echo "<frame src=\"./discussion.php?webtag=$webtag&folder=". $_GET['folder']. "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

        }else if (isset($_GET['pmid']) && is_numeric($_GET['pmid'])) {

            echo "<frame src=\"./pm.php?webtag=$webtag&mid=". $_GET['pmid']. "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

        }else {

            if ($start_page = bh_session_get_value('START_PAGE')) {

	        if ($start_page == 1) {
	            $final_uri = "./discussion.php?webtag=$webtag";
	        }elseif ($start_page == 2) {
	            $final_uri = "./pm.php?webtag=$webtag";
		}else {
		    $final_uri = "./start.php?webtag=$webtag";
		}

	    }else {

	        $final_uri = "./start.php?webtag=$webtag";
	    }

            echo "<frame src=\"", $final_uri, "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";
	}

    }else {

        if (isset($_GET['final_uri'])) {

            echo "<frame src=\"./forums.php?final_uri=", rawurlencode($_GET['final_uri']), "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

        }else if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

            echo "<frame src=\"./forums.php?final_uri=", rawurlencode("./discussion.php?msg=". $_GET['msg']), "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

        }else if (isset($_GET['folder']) && is_numeric($_GET['folder'])) {

            echo "<frame src=\"./forums.php?final_uri=", rawurlencode("./discussion.php?folder=". $_GET['folder']), "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

        }else if (isset($_GET['pmid']) && is_numeric($_GET['pmid'])) {

            echo "<frame src=\"./forums.php?final_uri=", rawurlencode("./pm.php?mid=". $_GET['pmid']), "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

        }else {

            echo "<frame src=\"./forums.php\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";
	}
    }

}else {

    // Load language file

    $lang = load_language_file();

    echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Frameset//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd\">\n";
    echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\" dir=\"{$lang['_textdir']}\">\n";
    echo "<head>\n";
    echo "<title>", forum_get_setting('forum_name', false, 'A Beehive Forum'), "</title>\n";
    echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset={$lang['_charset']}\">\n";
    echo "<link rel=\"stylesheet\" href=\"{$stylesheet}\" type=\"text/css\" />\n";
    echo "<link rel=\"icon\" href=\"images/favicon.ico\" type=\"image/ico\">\n";
    echo "</head>\n";

    // Check to see if the user has visited before and logged in.

    if (!isset($_COOKIE['bh_logon']) && user_guest_enabled() && $auto_logon) {

        bh_session_init(0); // auto login as guest

        // Fetch the forum settings

        $webtag = get_webtag();

        echo "<frameset rows=\"60,20,*\" frameborder=\"0\" framespacing=\"0\">\n";
        echo "<frame src=\"". $top_html. "\" name=\"top\" frameborder=\"0\" framespacing=\"0\" scrolling=\"no\" marginwidth=\"0\" marginheight=\"0\" noresize=\"noresize\" />\n";
	echo "<frame src=\"./nav.php?webtag=$webtag\" name=\"fnav\" frameborder=\"0\" framespacing=\"0\" scrolling=\"no\" marginwidth=\"0\" marginheight=\"0\" noresize=\"noresize\" />\n";

	if ($webtag) {

            if (isset($_GET['final_uri'])) {

                echo "<frame src=\"", rawurldecode($_GET['final_uri']), "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

            }elseif (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

                echo "<frame src=\"discussion.php?webtag=$webtag&msg=", $_GET['msg'], "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

            }else if (isset($_GET['folder'])) {

                echo "<frame src=\"discussion.php?webtag=$webtag&folder=", $_GET['folder'], "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

            }else if (isset($_GET['pmid'])) {

                echo "<frame src=\"./pm.php?webtag=$webtag&mid=", $_GET['pmid'], "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

            }else {

                echo "<frame src=\"./start.php?webtag=$webtag\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";
            }

	}else {

            if (isset($_GET['final_uri'])) {

                echo "<frame src=\"./forums.php?webtag=$webtag&final_uri=", rawurlencode($_GET['final_uri']), "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

            }elseif (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

                echo "<frame src=\"./forums.php?webtag=$webtag&final_uri=", rawurlencode("./discussion.php?webtag=$webtag&msg=", $_GET['msg']), "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

            }else if (isset($_GET['folder']) && is_numeric($_GET['folder'])) {

                echo "<frame src=\"./forums.php?webtag=$webtag&final_uri=". rawurlencode("./discussion.php?webtag=$webtag&folder=". $_GET['folder']). "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

            }else if (isset($_GET['pmid'])) {

                echo "<frame src=\"./forums.php?webtag=$webtag&final_uri=". rawurlencode("./pm.php?webtag=$webtag&mid=". $_GET['pmid']). "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

            }else {

                echo "<frame src=\"./forums.php?webtag=$webtag\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";
            }
	}

    }else {

        // Load language file

        $lang = load_language_file();

        // Fetch the forum settings

        $webtag = get_webtag();

        echo "<frameset rows=\"60,*\" frameborder=\"0\" framespacing=\"0\">\n";
        echo "<frame src=\"". $top_html. "\" name=\"top\" frameborder=\"0\" framespacing=\"0\" scrolling=\"no\" marginwidth=\"0\" marginheight=\"0\" noresize=\"noresize\" />\n";

        if (isset($_GET['final_uri'])) {

            echo "<frame src=\"./logon.php?webtag=$webtag&final_uri=", rawurlencode($_GET['final_uri']), "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

        }elseif (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

            echo "<frame src=\"./logon.php?webtag=$webtag&final_uri=". rawurlencode("./discussion.php?webtag=$webtag&msg=". $_GET['msg']). "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

        }else if (isset($_GET['folder']) && is_numeric($_GET['folder'])) {

            echo "<frame src=\"./logon.php?webtag=$webtag&final_uri=". rawurlencode("./discussion.php?webtag=$webtag&folder=". $_GET['folder']). "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

        }else if (isset($_GET['pmid']) && is_numeric($_GET['pmid'])) {

            echo "<frame src=\"./logon.php?webtag=$webtag&final_uri=". rawurlencode("./pm.php?webtag=$webtag&mid=". $_GET['pmid']). "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

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