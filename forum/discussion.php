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

/* $Id: discussion.php,v 1.46 2004-04-04 21:03:39 decoyduck Exp $ */

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
include_once("./include/header.inc.php");
include_once("./include/logon.inc.php");
include_once("./include/messages.inc.php");
include_once("./include/session.inc.php");

if (!$user_sess = bh_session_check()) {

    if (isset($HTTP_SERVER_VARS["REQUEST_METHOD"]) && $HTTP_SERVER_VARS["REQUEST_METHOD"] == "POST") {
        
        if (perform_logon(false)) {
	    
	    html_draw_top();

            echo "<h1>{$lang['loggedinsuccessfully']}</h1>";
            echo "<div align=\"center\">\n";
	    echo "<p><b>{$lang['presscontinuetoresend']}</b></p>\n";

            $request_uri = get_request_uri();

            echo "<form method=\"post\" action=\"$request_uri\" target=\"_self\">\n";

            foreach($HTTP_POST_VARS as $key => $value) {
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

// Load the wordfilter for the current user

$user_wordfilter = load_wordfilter();

echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Frameset//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd\">\n";
echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\" dir=\"{$lang['_textdir']}\">\n";
echo "<head>\n";
echo "<title>", forum_get_setting('forum_name', false, 'A Beehive Forum'), "</title>\n";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset={$lang['_charset']}\">\n";
echo "<link rel=\"stylesheet\" href=\"styles/style.css\" type=\"text/css\" />\n";
echo "<link rel=\"icon\" href=\"images/favicon.ico\" type=\"image/ico\">\n";
echo "</head>\n";
echo "<frameset cols=\"250,*\" border=\"1\">\n";

if (isset($HTTP_GET_VARS['folder']) && is_numeric($HTTP_GET_VARS['folder']) && folder_is_accessible($HTTP_GET_VARS['folder'])) {

    $fid = $HTTP_GET_VARS['folder'];
    $msg = messages_get_most_recent(bh_session_get_value('UID'), $fid);

    echo "  <frame src=\"./thread_list.php?webtag=$webtag&mode=0&amp;folder=$fid\" name=\"left\" frameborder=\"0\" framespacing=\"0\" />\n";
    echo "  <frame src=\"./messages.php?webtag=$webtag&msg=$msg\" name=\"right\" frameborder=\"0\" framespacing=\"0\" />\n";

}elseif (isset($HTTP_GET_VARS['msg']) && validate_msg($HTTP_GET_VARS['msg'])) {

    echo "  <frame src=\"./thread_list.php?webtag=$webtag&msg={$HTTP_GET_VARS['msg']}\" name=\"left\" frameborder=\"0\" framespacing=\"0\" />\n";
    echo "  <frame src=\"./messages.php?webtag=$webtag&msg={$HTTP_GET_VARS['msg']}\" name=\"right\" frameborder=\"0\" framespacing=\"0\" />\n";

}else {
    
    $msg = messages_get_most_recent(bh_session_get_value('UID'));

    echo "  <frame src=\"./thread_list.php?webtag=$webtag&msg=$msg\" name=\"left\" frameborder=\"0\" framespacing=\"0\" />\n";
    echo "  <frame src=\"./messages.php?webtag=$webtag&msg=$msg\" name=\"right\" frameborder=\"0\" framespacing=\"0\" />\n";
}

echo "</frameset>\n";
echo "</html>\n";

?>