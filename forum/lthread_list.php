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

/* $Id: lthread_list.php,v 1.81 2007-05-15 22:13:16 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "./include/");

// Light Mode Detection
define("BEEHIVEMODE_LIGHT", true);

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

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

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "folder.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "light.inc.php");
include_once(BH_INCLUDE_PATH. "messages.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "thread.inc.php");
include_once(BH_INCLUDE_PATH. "threads.inc.php");
include_once(BH_INCLUDE_PATH. "word_filter.inc.php");

// Light mode check to see if we should bounce to the logon screen.

if (!bh_session_active()) {

    $webtag = get_webtag($webtag_search);
    header_redirect("./llogon.php?webtag=$webtag");
}

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {

    $webtag = get_webtag($webtag_search);
    header_redirect("./llogon.php?webtag=$webtag");
}

// Check to see if the user is banned.

if (bh_session_user_banned()) {

    html_user_banned();
    exit;
}

// Check to see if the user has been approved.

if (!bh_session_user_approved()) {

    html_user_require_approval();
    exit;
}

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {

    header_redirect("./lforums.php");
}

// Load language file

$lang = load_language_file();

// Check that we have access to this forum

if (!forum_check_access_level()) {
    header_redirect("./lforums.php");
}

// Check that required variables are set

if (bh_session_get_value('UID') == 0) {

    $uid = 0; // default to UID 0 if no other UID specified

    if (isset($_GET['mode']) && is_numeric($_GET['mode'])) {
        
        // non-logged in users can only display "All" threads
        // or those in the past x days, since the other options
        // would be impossible

        if ($_GET['mode'] == ALL_DISCUSSIONS || $_GET['mode'] == TODAYS_DISCUSSIONS || $_GET['mode'] == TWO_DAYS_BACK || $_GET['mode'] == SEVEN_DAYS_BACK) {
            $mode = $_GET['mode'];
        }else {
            $mode = ALL_DISCUSSIONS;
        }

    }else {

        if (isset($_COOKIE["bh_{$webtag}_thread_mode"]) && is_numeric($_COOKIE["bh_{$webtag}_thread_mode"])) {
            $mode = $_COOKIE["bh_{$webtag}_thread_mode"];
        }else{
            $mode = ALL_DISCUSSIONS;
        }
    }

}else {

    $uid = bh_session_get_value('UID');

    $threads_any_unread = threads_any_unread();

    if (isset($_GET['markread'])) {
        
        if ($_GET['markread'] == THREAD_MARK_READ_VISIBLE) {
        
            if (isset($_GET['tid_array']) && is_array($_GET['tid_array'])) {

                $tid_array = preg_grep("/^[0-9]+$/", $_GET['tid_array']);

                $thread_data = array();
                
                threads_get_unread_data($thread_data, $tid_array);
                threads_mark_read($thread_data);
            }

        }elseif ($_GET['markread'] == THREAD_MARK_READ_ALL) {

            threads_mark_all_read();

        }elseif ($_GET['markread'] == THREAD_MARK_READ_FIFTY) {

            threads_mark_50_read();

        }elseif ($_GET['markread'] == THREAD_MARK_READ_FOLDER && isset($folder)) {

            threads_mark_folder_read($folder);
        }
    }

    if (isset($_GET['mode']) && is_numeric($_GET['mode'])) {

        $mode = $_GET['mode'];

        bh_setcookie("bh_{$webtag}_thread_mode", $mode);       

    }else {

        if (isset($_COOKIE["bh_{$webtag}_thread_mode"]) && is_numeric($_COOKIE["bh_{$webtag}_thread_mode"])) {

            $mode = $_COOKIE["bh_{$webtag}_thread_mode"];

            if ($mode == UNREAD_DISCUSSIONS && !$threads_any_unread) {

                $mode = ALL_DISCUSSIONS;
            }           

        }else {

            if ($threads_any_unread) {

                $mode = UNREAD_DISCUSSIONS;

            }else {

                $mode = ALL_DISCUSSIONS;
            }
        }
    }
}

if (isset($_GET['folder']) && is_numeric($_GET['folder'])) {

    $folder = $_GET['folder'];
    $mode = 0;

}else {

    $folder = false;
}

bh_setcookie("bh_{$webtag}_thread_mode", $mode);

if (isset($_GET['start_from']) && is_numeric($_GET['start_from'])) {
    $start_from = $_GET['start_from'];
}else {
    $start_from = 0;
}

// Output XHTML header
light_html_draw_top();

echo "<h1>{$lang['threadlist']}</h1>\n";
echo "<br />\n";

light_draw_thread_list($mode, $folder, $start_from);

echo "<h4>";

if (forums_get_available_count() > 1) {
    echo "<a href=\"lforums.php?webtag=$webtag\">{$lang['myforums']}</a> | ";
}

if (bh_session_get_value('UID') == 0) {
    echo "<a href=\"llogout.php?webtag=$webtag\">{$lang['login']}</a>";
}else {
    echo "<a href=\"llogout.php?webtag=$webtag\">{$lang['logout']}</a>";
}

echo "</h4>\n";
echo "<h6>&copy; ", date('Y'), " <a href=\"http://www.beehiveforum.net/\" target=\"_blank\">Project BeehiveForum</a></h6>\n";

light_html_draw_bottom();

?>