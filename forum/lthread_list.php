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

/* $Id: lthread_list.php,v 1.63 2005-03-10 21:17:52 decoyduck Exp $ */

// Light Mode Detection
define("BEEHIVEMODE_LIGHT", true);

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Installation checking functions
include_once("./include/install.inc.php");

// Check that Beehive is installed correctly
check_install();

// Multiple forum support
include_once("./include/forum.inc.php");

// Fetch the forum settings
$forum_settings = get_forum_settings();

include_once("./include/constants.inc.php");
include_once("./include/folder.inc.php");
include_once("./include/format.inc.php");
include_once("./include/html.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/light.inc.php");
include_once("./include/messages.inc.php");
include_once("./include/session.inc.php");
include_once("./include/thread.inc.php");
include_once("./include/threads.inc.php");
include_once("./include/word_filter.inc.php");

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri(true));
    $webtag = get_webtag($webtag_search);
    header_redirect("./llogon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri(true));
    header_redirect("./lforums.php?final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

// Check that we have access to this forum

if (!forum_check_access_level()) {
    header_redirect("./lforums.php");
}

// Check that required variables are set

$uid = bh_session_get_value('UID');

if (isset($_GET['markread'])) {

    if ($_GET['markread'] == 2 && isset($_GET['tids']) && is_array($_GET['tids'])) {
        threads_mark_read(explode(',', $_GET['tids']));
    }elseif ($_GET['markread'] == 0) {
        threads_mark_all_read();
    }elseif ($_GET['markread'] == 1) {
        threads_mark_50_read();
    }
}

if (!isset($_GET['mode'])) {
    if (!isset($_COOKIE['bh_thread_mode'])) {
        if (threads_any_unread()) { // default to "Unread" messages for a logged-in user, unless there aren't any
            $mode = 1;
        }else {
            $mode = 0;
        }
    }else {
        $mode = (is_numeric($_COOKIE['bh_thread_mode'])) ? $_COOKIE['bh_thread_mode'] : 0;
    }
}else {
    $mode = (is_numeric($_GET['mode'])) ? $_GET['mode'] : 0;
}

if (isset($_GET['folder']) && is_numeric($_GET['folder'])) {
    $folder = $_GET['folder'];
    $mode = 0;
}

bh_setcookie('bh_thread_mode', $mode);

if (isset($_GET['start_from']) && is_numeric($_GET['start_form'])) {
    $start_from = $_GET['start_from'];
}else {
    $start_from = 0;
}

// Output XHTML header
light_html_draw_top();

light_draw_thread_list();

if (bh_session_get_value('UID') == 0) {
    echo "<h4><a href=\"lforums.php?webtag=$webtag\">{$lang['myforums']}</a> | <a href=\"llogout.php?webtag=$webtag\">{$lang['login']}</a></h4>\n";
}else {
    echo "<h4><a href=\"lforums.php?webtag=$webtag\">{$lang['myforums']}</a> | <a href=\"llogout.php?webtag=$webtag\">{$lang['logout']}</a></h4>\n";
}

echo "<h6>&copy; ", date('Y'), " <a href=\"http://www.beehiveforum.net/\" target=\"_blank\">Project BeehiveForum</a></h6>\n";

light_html_draw_bottom();

?>