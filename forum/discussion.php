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

/* $Id: discussion.php,v 1.76 2005-03-24 00:22:43 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "./include/");

// Compress the output
include_once(BH_INCLUDE_PATH. "gzipenc.inc.php");

// Enable the error handler
include_once(BH_INCLUDE_PATH. "errorhandler.inc.php");

// Installation checking functions
include_once(BH_INCLUDE_PATH. "install.inc.php");

// Check that Beehive is installed correctly
check_install();

// Multiple forum support
include_once(BH_INCLUDE_PATH. "forum.inc.php");

// Fetch the forum settings
$forum_settings = forum_get_settings();

include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "messages.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "threads.inc.php");

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri(true));
    $webtag = get_webtag($webtag_search);
    header_redirect("./logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri(true));
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

// Forum Name

$forum_name = forum_get_setting('forum_name', false, 'A Beehive Forum');

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri(true));
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

$uid = bh_session_get_value('UID');
$request_uri = get_request_uri();

$dtdpath = html_get_path(true);

echo "<!DOCTYPE html SYSTEM \"$dtdpath/dtd/beehive-frameset.dtd\">\n";
echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\" dir=\"{$lang['_textdir']}\">\n";
echo "<head>\n";
echo "<title>$forum_name</title>\n";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset={$lang['_charset']}\" />\n";
echo "<meta name=\"robots\" content=\"noindex,follow\" />\n";
echo "<link rel=\"stylesheet\" href=\"styles/style.css\" type=\"text/css\" />\n";
echo "<link rel=\"icon\" href=\"images/favicon.ico\" type=\"image/ico\" />\n";
echo "<link rel=\"alternate\" type=\"application/rss+xml\" title=\"{$forum_name} RSS Feed\" href=\"threads_rss.php\" />\n";
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

}else if (isset($_GET['right']) && $_GET['right'] == 'search') {

    echo "  <frame src=\"./thread_list.php?webtag=$webtag\" name=\"left\" frameborder=\"0\" framespacing=\"0\" />\n";
    echo "  <frame src=\"./search.php?webtag=$webtag\" name=\"right\" frameborder=\"0\" framespacing=\"0\" />\n";

}else {

    if (threads_any_unread() && $msg = messages_get_most_recent_unread(bh_session_get_value('UID'))) {

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