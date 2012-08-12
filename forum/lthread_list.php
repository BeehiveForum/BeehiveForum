<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
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

// Bootstrap
require_once 'lboot.php';

// Includes required by this page.
require_once BH_INCLUDE_PATH. 'cache.inc.php';
require_once BH_INCLUDE_PATH. 'constants.inc.php';
require_once BH_INCLUDE_PATH. 'folder.inc.php';
require_once BH_INCLUDE_PATH. 'format.inc.php';
require_once BH_INCLUDE_PATH. 'header.inc.php';
require_once BH_INCLUDE_PATH. 'html.inc.php';
require_once BH_INCLUDE_PATH. 'lang.inc.php';
require_once BH_INCLUDE_PATH. 'light.inc.php';
require_once BH_INCLUDE_PATH. 'logon.inc.php';
require_once BH_INCLUDE_PATH. 'messages.inc.php';
require_once BH_INCLUDE_PATH. 'session.inc.php';
require_once BH_INCLUDE_PATH. 'thread.inc.php';
require_once BH_INCLUDE_PATH. 'threads.inc.php';
require_once BH_INCLUDE_PATH. 'word_filter.inc.php';

// Check thread list cache
cache_check_thread_list();

// Get the folders the user can see.
if (!($available_folders = folder_get_available_array())) {
    $available_folders = array();
}

// Are we viewing a specific folder only?
if (isset($_REQUEST['folder']) && in_array($_REQUEST['folder'], $available_folders)) {
    $folder = $_REQUEST['folder'];
} else {
    $folder = false;
}

// View offset.
if (isset($_REQUEST['start_from']) && is_numeric($_REQUEST['start_from'])) {
    $start_from = $_REQUEST['start_from'];
} else {
    $start_from = 0;
}

// View mode
if (isset($_REQUEST['mode']) && is_numeric($_REQUEST['mode'])) {
    $mode = $_REQUEST['mode'];
}

// Check that required variables are set
if (!session::logged_in()) {

    // non-logged in users can only display "All" threads
    // or those in the past x days, since the other options
    // would be impossible
    if (!isset($mode) || ($mode != ALL_DISCUSSIONS && $mode != TODAYS_DISCUSSIONS && $mode != TWO_DAYS_BACK && $mode != SEVEN_DAYS_BACK)) {
        $mode = ALL_DISCUSSIONS;
    }

} else {

    $threads_any_unread = threads_any_unread();

    if (isset($mode) && is_numeric($mode)) {

        session::set_value('THREAD_MODE', $mode);

    } else {

        if (!($mode = session::get_value('THREAD_MODE'))) $mode = UNREAD_DISCUSSIONS;

        if ($mode == UNREAD_DISCUSSIONS && !$threads_any_unread) {
            $mode = ALL_DISCUSSIONS;
        }
    }

    if (isset($_REQUEST['mark_read_submit'])) {

        if (isset($_REQUEST['mark_read_confirm']) && ($_REQUEST['mark_read_confirm'] == 'Y')) {

            if ($_REQUEST['mark_read_type'] == THREAD_MARK_READ_VISIBLE) {

                if (isset($_REQUEST['mark_read_threads']) && strlen(trim($_REQUEST['mark_read_threads'])) > 0) {

                    $thread_data = array();

                    $mark_read_threads = trim($_REQUEST['mark_read_threads']);

                    $mark_read_threads_array = array_filter(explode(',', $mark_read_threads), 'is_numeric');

                    threads_get_unread_data($thread_data, $mark_read_threads_array);

                    if (threads_mark_read($thread_data)) {

                        header_redirect("lthread_list.php?webtag=$webtag&mode=$mode&folder=$folder&mark_read_success=true");
                        exit;

                    } else {

                        $error_msg_array[] = gettext("Failed to mark selected threads as read");
                        $valid = false;
                    }
                }

            } else if ($_REQUEST['mark_read_type'] == THREAD_MARK_READ_ALL) {

                if (threads_mark_all_read()) {

                    header_redirect("lthread_list.php?webtag=$webtag&mode=$mode&folder=$folder&mark_read_success=true");
                    exit;

                } else {

                    $error_msg_array[] = gettext("Failed to mark selected threads as read");
                    $valid = false;
                }

            } else if ($_REQUEST['mark_read_type'] == THREAD_MARK_READ_FIFTY) {

                if (threads_mark_50_read()) {

                    header_redirect("lthread_list.php?webtag=$webtag&mode=$mode&folder=$folder&mark_read_success=true");
                    exit;

                } else {

                    $error_msg_array[] = gettext("Failed to mark selected threads as read");
                    $valid = false;
                }

            } else if (($_REQUEST['mark_read_type'] == THREAD_MARK_READ_FOLDER) && (isset($folder) && is_numeric($folder))) {

                if (threads_mark_folder_read($folder)) {

                    header_redirect("lthread_list.php?webtag=$webtag&mode=$mode&folder=$folder&mark_read_success=true");
                    exit;

                } else {

                    $error_msg_array[] = gettext("Failed to mark selected threads as read");
                    $valid = false;
                }
            }

        } else {

            unset($_REQUEST['mark_read_submit'], $_REQUEST['mark_read_confirm']);

            light_html_draw_top();
            light_html_display_msg(gettext("Confirm"), gettext("Are you sure you want to mark the selected threads as read?"), 'lthread_list.php', 'post', array('mark_read_submit' => gettext("Confirm"), 'cancel' => gettext("Cancel")), array_merge($_REQUEST, array('mark_read_confirm' => 'Y')));
            light_html_draw_bottom();
            exit;
        }
    }
}

light_html_draw_top();

light_draw_thread_list($mode, $folder, $start_from);

light_html_draw_bottom();

?>