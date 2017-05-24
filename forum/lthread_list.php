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

// Required includes
require_once BH_INCLUDE_PATH . 'cache.inc.php';
require_once BH_INCLUDE_PATH . 'constants.inc.php';
require_once BH_INCLUDE_PATH . 'folder.inc.php';
require_once BH_INCLUDE_PATH . 'forum.inc.php';
require_once BH_INCLUDE_PATH . 'header.inc.php';
require_once BH_INCLUDE_PATH . 'html.inc.php';
require_once BH_INCLUDE_PATH . 'light.inc.php';
require_once BH_INCLUDE_PATH . 'session.inc.php';
require_once BH_INCLUDE_PATH . 'threads.inc.php';
// End Required includes

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
if (isset($_REQUEST['page']) && is_numeric($_REQUEST['page'])) {
    $page = intval($_REQUEST['page']);
} else {
    $page = 1;
}

// View mode
if (isset($_REQUEST['mode']) && is_numeric($_REQUEST['mode'])) {
    $mode = intval($_REQUEST['mode']);
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

        $_SESSION['THREAD_MODE'] = $mode;

        if ($mode == SEARCH_RESULTS) {

            header_redirect("lsearch.php?webtag=$webtag&page=1");
            exit;
        }

    } else {

        if (isset($_SESSION['THREAD_MODE']) && is_numeric($_SESSION['THREAD_MODE']) && ($_SESSION['THREAD_MODE'] != SEARCH_RESULTS)) {
            $mode = $_SESSION['THREAD_MODE'];
        } else {
            $mode = UNREAD_DISCUSSIONS;
        }

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
            light_navigation_bar();
            light_html_display_msg(gettext("Confirm"), gettext("Are you sure you want to mark the selected threads as read?"), 'lthread_list.php', 'post', array(
                'mark_read_submit' => gettext("Confirm"),
                'cancel' => gettext("Cancel")
            ), array_merge($_REQUEST, array('mark_read_confirm' => 'Y')));
            light_html_draw_bottom();
            exit;
        }
    }
}

light_html_draw_top(
    array(
        'js' => array(
            'js/thread_list.js'
        )
    )
);

if (forums_get_available_count() > 1 || !forum_get_default()) {

    light_navigation_bar(
        array(
            'back' => "lforums.php?webtag=$webtag",
            'nav_links' => array(
                array(
                    'text' => gettext('New Discussion'),
                    'url' => "lpost.php?webtag=$webtag",
                    'class' => 'post_new',
                    'image' => 'mobile_post',
                ),
            )
        )
    );

} else {

    light_navigation_bar(
        array(
            'nav_links' => array(
                array(
                    'text' => gettext('New Discussion'),
                    'url' => "lpost.php?webtag=$webtag",
                    'class' => 'post_new',
                    'image' => 'mobile_post',
                ),
            )
        )
    );
}

light_draw_thread_list($mode, $folder, $page);

light_html_draw_bottom();