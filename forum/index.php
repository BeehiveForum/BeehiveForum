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

/* $Id: index.php,v 1.94 2004-08-17 18:28:53 tribalonline Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Installation checking functions
include_once("./include/install.inc.php");

// Check that Beehive is installed correctly
check_install();

//Multiple forum support
include_once("./include/forum.inc.php");

$forum_settings = get_forum_settings();

include_once("./include/header.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/logon.inc.php");
include_once("./include/messages.inc.php");
include_once("./include/session.inc.php");

$user_sess = bh_session_check(false);

// Does the forum allow auto logon of guests?

$auto_logon = forum_get_setting('auto_logon', 'Y', false);

// Top frame and style sheet

$top_html   = html_get_top_page();
$stylesheet = html_get_style_sheet();

if ((isset($_COOKIE['bh_sess_hash']) && is_md5($_COOKIE['bh_sess_hash'])) || (user_guest_enabled() && $auto_logon && !isset($_COOKIE['bh_logon']))) {

    // Load language file

    $lang = load_language_file();

    // Fetch the forum settings

    $webtag = get_webtag($webtag_search);

    // Calculate how tall the nav frameset should be based on the user's fontsize.

    $navsize = bh_session_get_value('FONT_SIZE');
    $navsize = max(($navsize ? $navsize * 2 : 22), 22);

    echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Frameset//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd\">\n";
    echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\" dir=\"{$lang['_textdir']}\">\n";
    echo "<head>\n";
    echo "<title>", forum_get_setting('forum_name', false, 'A Beehive Forum'), "</title>\n";
    echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset={$lang['_charset']}\">\n";
    echo "<link rel=\"stylesheet\" href=\"{$stylesheet}\" type=\"text/css\" />\n";
    echo "<link rel=\"icon\" href=\"images/favicon.ico\" type=\"image/ico\">\n";
    echo "</head>\n";

    echo "<frameset rows=\"60,$navsize,*\" frameborder=\"0\" framespacing=\"0\">\n";
    echo "<frame src=\"$top_html\" name=\"ftop\" frameborder=\"0\" framespacing=\"0\" scrolling=\"no\" marginwidth=\"0\" marginheight=\"0\" noresize=\"noresize\" />\n";
    echo "<frame src=\"./nav.php?webtag=$webtag\" name=\"fnav\" frameborder=\"0\" framespacing=\"0\" scrolling=\"no\" marginwidth=\"0\" marginheight=\"0\" noresize=\"noresize\" />\n";

    if ($webtag) {

        if (isset($_GET['final_uri'])) {

	    if (stristr(rawurldecode($_GET['final_uri']), "?")) {
                echo "<frame src=\"". rawurldecode($_GET['final_uri']). "&amp;webtag=$webtag\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";
	    }else {
                echo "<frame src=\"". rawurldecode($_GET['final_uri']). "?webtag=$webtag\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";
	    }

        }else if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

            echo "<frame src=\"./discussion.php?webtag=$webtag&amp;msg=". $_GET['msg']. "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

        }else if (isset($_GET['folder']) && is_numeric($_GET['folder'])) {

            echo "<frame src=\"./discussion.php?webtag=$webtag&amp;folder=". $_GET['folder']. "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

        }else if (isset($_GET['pmid']) && is_numeric($_GET['pmid'])) {

            echo "<frame src=\"./pm.php?webtag=$webtag&amp;mid=". $_GET['pmid']. "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

        }else {

            if ($start_page = bh_session_get_value('START_PAGE')) {

	        if ($start_page == 1) {
	            $final_uri = "./discussion.php?webtag=$webtag";
	        }elseif ($start_page == 2) {
	            $final_uri = "./pm.php?webtag=$webtag";
	        }elseif ($start_page == 3) {
	            $final_uri = "./start.php?webtag=$webtag&left=threadlist";
		}else {
		    $final_uri = "./start.php?webtag=$webtag";
		}

	    }else {

	        $final_uri = "./start.php?webtag=$webtag";
	    }

            echo "<frame src=\"$final_uri\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";
	}

    }else {

        if (isset($_GET['final_uri'])) {

            echo "<frame src=\"./forums.php?webtag_search=$webtag_search&amp;final_uri=", rawurlencode($_GET['final_uri']), "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

        }else if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

            echo "<frame src=\"./forums.php?webtag_search=$webtag_search&amp;final_uri=", rawurlencode("./discussion.php?msg=". $_GET['msg']), "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

        }else if (isset($_GET['folder']) && is_numeric($_GET['folder'])) {

            echo "<frame src=\"./forums.php?webtag_search=$webtag_search&amp;final_uri=", rawurlencode("./discussion.php?folder=". $_GET['folder']), "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

        }else if (isset($_GET['pmid']) && is_numeric($_GET['pmid'])) {

            echo "<frame src=\"./forums.php?webtag_search=$webtag_search&amp;final_uri=", rawurlencode("./pm.php?mid=". $_GET['pmid']), "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

        }else {

            echo "<frame src=\"./forums.php?webtag_search=$webtag_search\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";
	}
    }

}else {

    // Load language file

    $lang = load_language_file();

    //echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Frameset//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd\">\n";
    echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\" dir=\"{$lang['_textdir']}\">\n";
    echo "<head>\n";
    echo "<title>", forum_get_setting('forum_name', false, 'A Beehive Forum'), "</title>\n";
    echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset={$lang['_charset']}\">\n";
    echo "<link rel=\"stylesheet\" href=\"{$stylesheet}\" type=\"text/css\" />\n";
    echo "<link rel=\"icon\" href=\"images/favicon.ico\" type=\"image/ico\">\n";
    echo "</head>\n";

    // Fetch the forum settings

    $webtag = get_webtag($webtag_search);

    echo "<frameset rows=\"60,*\" frameborder=\"0\" framespacing=\"0\">\n";
    echo "<frame src=\"$top_html\" name=\"top\" frameborder=\"0\" framespacing=\"0\" scrolling=\"no\" marginwidth=\"0\" marginheight=\"0\" noresize=\"noresize\" />\n";

    if (isset($_GET['final_uri'])) {

        echo "<frame src=\"./logon.php?webtag=$webtag&amp;final_uri=", rawurlencode($_GET['final_uri']), "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

    }elseif (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

        echo "<frame src=\"./logon.php?webtag=$webtag&amp;final_uri=". rawurlencode("./discussion.php?webtag=$webtag&amp;msg=". $_GET['msg']). "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

    }else if (isset($_GET['folder']) && is_numeric($_GET['folder'])) {

        echo "<frame src=\"./logon.php?webtag=$webtag&amp;final_uri=". rawurlencode("./discussion.php?webtag=$webtag&amp;folder=". $_GET['folder']). "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

    }else if (isset($_GET['pmid']) && is_numeric($_GET['pmid'])) {

        echo "<frame src=\"./logon.php?webtag=$webtag&amp;final_uri=". rawurlencode("./pm.php?webtag=$webtag&amp;mid=". $_GET['pmid']). "\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";

    }else {

        echo "<frame src=\"./logon.php?webtag=$webtag\" name=\"main\" frameborder=\"0\" framespacing=\"0\" />\n";
    }
}

echo "<noframes>\n";
echo "<body>\n";
echo "<h1>{$lang['noframessupport']}</h1>\n";
echo "<p>{$lang['uselightversion']}</p>\n";
echo "</body>\n";
echo "</noframes>\n";
echo "</frameset>\n";
echo "</html>\n";

?>