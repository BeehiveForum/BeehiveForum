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

/* $Id: discussion.php,v 1.56 2004-04-26 19:55:45 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Multiple forum support
include_once("./include/forum.inc.php");

// Fetch the forum settings
$forum_settings = get_forum_settings();

include_once("./include/header.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/logon.inc.php");
include_once("./include/messages.inc.php");
include_once("./include/session.inc.php");
include_once("./include/threads.inc.php");

if (!$user_sess = bh_session_check()) {

    if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {

        if (perform_logon(false)) {

	    html_draw_top();

            echo "<h1>{$lang['loggedinsuccessfully']}</h1>";
            echo "<div align=\"center\">\n";
	    echo "<p><b>{$lang['presscontinuetoresend']}</b></p>\n";

            $request_uri = get_request_uri();

            echo "<form method=\"post\" action=\"$request_uri\" target=\"_self\">\n";

            foreach($_POST as $key => $value) {
	        form_input_hidden($key, _htmlentities(_stripslashes($value)));
            }

	    echo form_submit(md5(uniqid(rand())), $lang['continue']), "&nbsp;";
            echo form_button(md5(uniqid(rand())), $lang['cancel'], "onclick=\"self.location.href='$request_uri'\""), "\n";
	    echo "</form>\n";

	    html_draw_bottom();
	    exit;
	}

    }else {
        html_draw_top();
        draw_logon_form(false);
	html_draw_bottom();
	exit;
    }
}

// Load language file

$lang = load_language_file();

// Check we have a webtag

if (!$webtag = get_webtag()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?final_uri=$request_uri");
}

echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Frameset//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd\">\n";
echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\" dir=\"{$lang['_textdir']}\">\n";
echo "<head>\n";
echo "<title>", forum_get_setting('forum_name', false, 'A Beehive Forum'), "</title>\n";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset={$lang['_charset']}\">\n";
echo "<link rel=\"stylesheet\" href=\"styles/style.css\" type=\"text/css\" />\n";
echo "<link rel=\"icon\" href=\"images/favicon.ico\" type=\"image/ico\">\n";
echo "</head>\n";
echo "<frameset cols=\"250,*\" border=\"1\">\n";

if (isset($_GET['folder']) && is_numeric($_GET['folder']) && folder_is_accessible($_GET['folder'])) {

    $fid = $_GET['folder'];
    $msg = messages_get_most_recent(bh_session_get_value('UID'), $fid);

    echo "  <frame src=\"./thread_list.php?webtag=$webtag&amp;mode=0&amp;folder=$fid\" name=\"left\" frameborder=\"0\" framespacing=\"0\" />\n";
    echo "  <frame src=\"./messages.php?webtag=$webtag&amp;msg=$msg\" name=\"right\" frameborder=\"0\" framespacing=\"0\" />\n";

}elseif (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

    echo "  <frame src=\"./thread_list.php?webtag=$webtag&amp;msg={$_GET['msg']}\" name=\"left\" frameborder=\"0\" framespacing=\"0\" />\n";
    echo "  <frame src=\"./messages.php?webtag=$webtag&amp;msg={$_GET['msg']}\" name=\"right\" frameborder=\"0\" framespacing=\"0\" />\n";

}else {

    if (threads_any_unread()) {

        $msg = messages_get_most_recent_unread(bh_session_get_value('UID'));

        echo "  <frame src=\"./thread_list.php?webtag=$webtag&amp;msg=$msg\" name=\"left\" frameborder=\"0\" framespacing=\"0\" />\n";
        echo "  <frame src=\"./messages.php?webtag=$webtag&amp;msg=$msg\" name=\"right\" frameborder=\"0\" framespacing=\"0\" />\n";

    }else {

        bh_setcookie('bh_thread_mode', 0);

        $msg = messages_get_most_recent(bh_session_get_value('UID'));

        echo "  <frame src=\"./thread_list.php?webtag=$webtag&amp;msg=$msg\" name=\"left\" frameborder=\"0\" framespacing=\"0\" />\n";
        echo "  <frame src=\"./messages.php?webtag=$webtag&amp;msg=$msg\" name=\"right\" frameborder=\"0\" framespacing=\"0\" />\n";
    }
}

echo "</frameset>\n";
echo "</html>\n";

?>