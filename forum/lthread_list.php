<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

Beehive Forum is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Beehive; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307
USA
======================================================================*/

/* $Id: lthread_list.php,v 1.107 2008-09-23 23:54:06 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

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

// Fetch Forum Settings

$forum_settings = forum_get_settings();

// Fetch Global Forum Settings

$forum_global_settings = forum_get_global_settings();

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

// Get webtag

$webtag = get_webtag();

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    header_redirect("llogon.php?webtag=$webtag");
}

// Light mode check to see if we should bounce to the logon screen.

if (!bh_session_active()) {
    header_redirect("llogon.php?webtag=$webtag");
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

if (!forum_check_webtag_available($webtag)) {
    $request_uri = rawurlencode(get_request_uri(false));
    header_redirect("lforums.php?webtag_error&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

// Check that we have access to this forum

if (!forum_check_access_level()) {
    header_redirect("lforums.php");
}

// Are we viewing a specific folder only?

if (isset($_GET['folder']) && is_numeric($_GET['folder'])) {

    $folder = $_GET['folder'];
    $mode = 0;

}else if (isset($_POST['folder']) && is_numeric($_POST['folder'])) {

    $folder = $_POST['folder'];
    $mode = 0;

}else {

    $folder = false;
}

// View offset.

if (isset($_GET['start_from']) && is_numeric($_GET['start_from'])) {
    $start_from = $_GET['start_from'];
}else if (isset($_POST['start_from']) && is_numeric($_POST['start_from'])) {
    $start_from = $_POST['start_from'];
}else {
    $start_from = 0;
}

// View mode

if (isset($_GET['mode']) && is_numeric($_GET['mode'])) {
    $mode = $_GET['mode'];
}else if (isset($_POST['mode']) && is_numeric($_POST['mode'])) {
    $mode = $_POST['mode'];
}

// Check that required variables are set

if (user_is_guest()) {

    // default to UID 0 if no other UID specified

    $uid = 0;

    // non-logged in users can only display "All" threads
    // or those in the past x days, since the other options
    // would be impossible

    if (!isset($mode) || ($mode != ALL_DISCUSSIONS && $mode != TODAYS_DISCUSSIONS && $mode != TWO_DAYS_BACK && $mode != SEVEN_DAYS_BACK)) {
        $mode = ALL_DISCUSSIONS;
    }

}else {

    $uid = bh_session_get_value('UID');

    $threads_any_unread = threads_any_unread();

    if (isset($mode) && is_numeric($mode)) {

        bh_setcookie("bh_{$webtag}_light_thread_mode", $mode);

    }else {

        $mode = bh_getcookie("bh_{$webtag}_light_thread_mode", false, UNREAD_DISCUSSIONS);

        if ($mode == UNREAD_DISCUSSIONS && !$threads_any_unread) {
            $mode = ALL_DISCUSSIONS;
        }
    }

    if (isset($_POST['mark_read_submit'])) {

        if (isset($_POST['mark_read_confirm']) && $_POST['mark_read_confirm'] == 'Y') {

            if ($_POST['mark_read_type'] == THREAD_MARK_READ_VISIBLE) {

                if (isset($_POST['mark_read_threads']) && strlen(trim(_stripslashes($_POST['mark_read_threads'])))) {

                    $thread_data = array();

                    $mark_read_threads = trim(_stripslashes($_POST['mark_read_threads']));

                    $mark_read_threads_array = preg_grep("/^[0-9]+$/Du", explode(',', $mark_read_threads));

                    threads_get_unread_data($thread_data, $mark_read_threads_array);

                    if (threads_mark_read($thread_data)) {

                        header_redirect("lthread_list.php?webtag=$webtag&mode=$mode&start_from=$start_from&folder=$folder&mark_read_success=true");
                        exit;

                    }else {

                        $error_msg_array[] = $lang['failedtomarkselectedthreadsasread'];
                        $valid = false;
                    }
                }

            }elseif ($_POST['mark_read_type'] == THREAD_MARK_READ_ALL) {

                if (threads_mark_all_read()) {

                    header_redirect("lthread_list.php?webtag=$webtag&mode=$mode&start_from=$start_from&folder=$folder&mark_read_success=true");
                    exit;

                }else {

                    $error_msg_array[] = $lang['failedtomarkselectedthreadsasread'];
                    $valid = false;
                }

            }elseif ($_POST['mark_read_type'] == THREAD_MARK_READ_FIFTY) {

                if (threads_mark_50_read()) {

                    header_redirect("lthread_list.php?webtag=$webtag&mode=$mode&start_from=$start_from&folder=$folder&mark_read_success=true");
                    exit;

                }else {

                    $error_msg_array[] = $lang['failedtomarkselectedthreadsasread'];
                    $valid = false;
                }

            }elseif ($_POST['mark_read_type'] == THREAD_MARK_READ_FOLDER && isset($folder) && is_numeric($folder)) {

                if (threads_mark_folder_read($folder)) {

                    header_redirect("lthread_list.php?webtag=$webtag&mode=$mode&start_from=$start_from&folder=$folder&mark_read_success=true");
                    exit;

                }else {

                    $error_msg_array[] = $lang['failedtomarkselectedthreadsasread'];
                    $valid = false;
                }
            }

        }else {

            unset($_POST['mark_read_submit'], $_POST['mark_read_confirm']);

            light_html_draw_top("robots=noindex,nofollow");
            light_html_display_msg($lang['confirm'], $lang['confirmmarkasread'], 'lthread_list.php', 'post', array('mark_read_submit' => $lang['confirm'], 'cancel' => $lang['cancel']), array_merge($_POST, array('mark_read_confirm' => 'Y')));
            light_html_draw_bottom();
            exit;
        }
    }
}

bh_setcookie("bh_{$webtag}_light_thread_mode", $mode);

// Output XHTML header
light_html_draw_top();

echo "<script language=\"javascript\" type=\"text/javascript\">\n";
echo "<!--\n\n";
echo "function confirmMarkAsRead()\n";
echo "{\n";
echo "    var mark_read_type = getObjsByName('mark_read_type')[0];\n";
echo "    var mark_read_confirm = getObjsByName('mark_read_confirm')[0];\n\n";
echo "    if ((typeof mark_read_type == 'object') && (typeof mark_read_confirm == 'object')) {\n\n";
echo "        if (window.confirm('", html_js_safe_str($lang['confirmmarkasread']), "')) {\n\n";
echo "            mark_read_confirm.value = 'Y';\n";
echo "            return true;\n";
echo "        }\n";
echo "    }\n\n";
echo "    return false;\n";
echo "}\n\n";
echo "//-->\n";
echo "</script>\n";

echo "<h1>{$lang['threadlist']}</h1>\n";
echo "<br />\n";

light_draw_thread_list($mode, $folder, $start_from);

echo "<h4>";

if (forums_get_available_count() > 1) {
    echo "<a href=\"lforums.php?webtag=$webtag\">{$lang['myforums']}</a> | ";
}

if (user_is_guest()) {
    echo "<a href=\"llogout.php?webtag=$webtag\">{$lang['login']}</a>";
}else {
    echo "<a href=\"llogout.php?webtag=$webtag\">{$lang['logout']}</a>";
}

echo "</h4>\n";
echo "<h6>&copy; ", date('Y'), " <a href=\"http://www.beehiveforum.net/\" target=\"_blank\">Project Beehive Forum</a></h6>\n";

light_html_draw_bottom();

?>