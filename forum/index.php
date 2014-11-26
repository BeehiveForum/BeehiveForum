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
require_once 'boot.php';

// Required includes
require_once BH_INCLUDE_PATH . 'browser.inc.php';
require_once BH_INCLUDE_PATH . 'cache.inc.php';
require_once BH_INCLUDE_PATH . 'constants.inc.php';
require_once BH_INCLUDE_PATH . 'folder.inc.php';
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'forum.inc.php';
require_once BH_INCLUDE_PATH . 'header.inc.php';
require_once BH_INCLUDE_PATH . 'html.inc.php';
require_once BH_INCLUDE_PATH . 'light.inc.php';
require_once BH_INCLUDE_PATH . 'messages.inc.php';
require_once BH_INCLUDE_PATH . 'pm.inc.php';
require_once BH_INCLUDE_PATH . 'server.inc.php';
require_once BH_INCLUDE_PATH . 'session.inc.php';
require_once BH_INCLUDE_PATH . 'thread.inc.php';
require_once BH_INCLUDE_PATH . 'threads.inc.php';
require_once BH_INCLUDE_PATH . 'user.inc.php';
// End Required includes

// Don't cache this page
cache_disable();

if (isset($_GET['view']) && ($_GET['view'] == 'full')) {

    html_set_cookie('view', 'full');
    header_redirect('index.php');

} else if (isset($_GET['view']) && ($_GET['view'] == 'mobile')) {

    html_set_cookie('view', 'mobile');
    header_redirect('index.php');
}

$top_html = html_get_top_page();

$hide_navigation = false;

if (!browser_mobile() && !session::is_search_engine()) {

    if (isset($_GET['final_uri']) && strlen(trim($_GET['final_uri'])) > 0) {

        $available_files_preg = implode("|^", array_map('preg_quote_callback', get_available_files()));

        $available_admin_files_preg = implode("|^", array_map('preg_quote_callback', get_available_admin_files()));

        $my_controls_preg = implode("|^", array_map('preg_quote_callback', get_available_user_files()));

        if (preg_match("/^$available_files_preg/u", trim($_GET['final_uri'])) > 0) {

            $final_uri = href_cleanup_query_keys($_GET['final_uri']);

            if (preg_match("/^logon.php/u", $final_uri) > 0) {

                $hide_navigation = true;

            } else if (preg_match("/^$available_admin_files_preg/u", $final_uri) > 0) {

                $final_uri = rawurlencode($final_uri);
                $final_uri = "admin.php?webtag=$webtag&page=$final_uri";

            } else if (preg_match("/^$my_controls_preg/u", $final_uri) > 0) {

                $final_uri = rawurlencode(href_cleanup_query_keys($final_uri));
                $final_uri = "user.php?webtag=$webtag&page=$final_uri";
            }
        }
    }

    html_draw_top(
        array(
            'frame_set_html' => true,
            'pm_popup_disabled' => true,
            'robots' => 'index,follow'
        )
    );

    if (isset($_SESSION['FONT_SIZE']) && is_numeric($_SESSION['FONT_SIZE'])) {
        $navsize = max(max(min($_SESSION['FONT_SIZE'], 15), 5) * 2, 22);
    } else {
        $navsize = 22;
    }

    if (!isset($final_uri)) {

        if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

            $final_uri = "discussion.php?webtag=$webtag&msg={$_GET['msg']}";

        } else if (isset($_GET['folder']) && is_numeric($_GET['folder'])) {

            $final_uri = "discussion.php?webtag=$webtag&folder={$_GET['folder']}";

        } else if (isset($_GET['mid']) && is_numeric($_GET['mid'])) {

            $final_uri = "pm.php?webtag=$webtag&mid={$_GET['mid']}";

        } else {

            if (isset($_SESSION['START_PAGE']) && is_numeric($_SESSION['START_PAGE'])) {

                if ($_SESSION['START_PAGE'] == START_PAGE_MESSAGES) {
                    $final_uri = "discussion.php?webtag=$webtag";
                } else if ($_SESSION['START_PAGE'] == START_PAGE_INBOX) {
                    $final_uri = "pm.php?webtag=$webtag";
                } else {
                    $final_uri = "start.php?webtag=$webtag";
                }

            } else {

                $final_uri = "start.php?webtag=$webtag";
            }
        }
    }

    if ($hide_navigation) {

        $frameset = new html_frameset_rows('index', "60,*");
        $frameset->html_frame($top_html, html_get_frame_name('ftop'), 0, 'no', 'noresize');
        $frameset->html_frame($final_uri, html_get_frame_name('main'));
        $frameset->output_html(false);

    } else {

        $frameset = new html_frameset_rows('index', "60,$navsize,*");
        $frameset->html_frame($top_html, html_get_frame_name('ftop'), 0, 'no', 'noresize');
        $frameset->html_frame("nav.php?webtag=$webtag", html_get_frame_name('fnav'), 0, 'no', 'noresize');
        $frameset->html_frame($final_uri, html_get_frame_name('main'));
        $frameset->output_html(false);
    }

    echo "<noframes>\n";
    echo "<body>\n";
}

if (forum_check_webtag_available($webtag, false)) {

    if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

        list($tid, $pid) = explode('.', $_GET['msg']);

        if (!$folder_data = thread_get_folder($tid)) {

            light_html_display_error_msg(gettext("The requested folder could not be found or access was denied."));
            return;
        }

        $perm_folder_moderate = session::check_perm(USER_PERM_FOLDER_MODERATE, $folder_data['FID']);

        if (!$thread_data = thread_get($tid, $perm_folder_moderate, false, $perm_folder_moderate)) {

            light_html_display_error_msg(gettext("The requested thread could not be found or access was denied."));
            return;
        }

        if (!$messages = messages_get($tid, $pid, 10)) {

            light_html_display_error_msg(gettext("That post does not exist in this thread!"));
            return;
        }

        if (browser_mobile()) {

            light_html_draw_top(
                array(
                    'js' => array(
                        'js/messages.js'
                    )
                )
            );
        }

        $nav_links = array(
            array(
                'text' => gettext('Show messages'),
                'url' => '#',
                'class' => 'navigation',
                'html' => light_messages_navigation_strip($tid, $pid, $thread_data['LENGTH'], 10),
                'image' => 'mobile_navigation'
            )
        );

        if (!$thread_data['CLOSED'] && session::check_perm(USER_PERM_POST_CREATE, $folder_data['FID'])) {

            array_unshift(
                $nav_links,
                array(
                    'text' => gettext('Reply to All'),
                    'url' => "lpost.php?webtag=$webtag&reply_to=$tid.0&return_msg=$tid.$pid",
                    'class' => 'reply_all',
                    'image' => 'mobile_reply_all',
                )
            );
        }

        light_navigation_bar(
            array(
                'back' => "lthread_list.php?webtag=$webtag",
                'nav_links' => $nav_links,
            )
        );

        light_draw_messages($tid, $pid, $thread_data, $messages);

    } else if (isset($_GET['mid']) && is_numeric($_GET['mid'])) {

        if (!session::logged_in()) {
            light_html_guest_error();
        }

        light_pm_enabled();

        pm_user_prune_folders($_SESSION['UID']);

        if (browser_mobile()) {

            light_html_draw_top(
                array(
                    'js' => array(
                        'js/pm.js'
                    )
                )
            );
        }

        light_navigation_bar(
            array(
                'back' => "lpm.php?webtag=$webtag",
            )
        );

        light_draw_pm_inbox();

    } else {

        if (!($available_folders = folder_get_available_array())) {
            $available_folders = array();
        }

        if (isset($_REQUEST['folder']) && in_array($_REQUEST['folder'], $available_folders)) {
            $folder = $_REQUEST['folder'];
        } else {
            $folder = false;
        }

        if (isset($_REQUEST['start_from']) && is_numeric($_REQUEST['start_from'])) {
            $start_from = $_REQUEST['start_from'];
        } else {
            $start_from = 0;
        }

        if (isset($_REQUEST['mode']) && is_numeric($_REQUEST['mode'])) {
            $mode = $_REQUEST['mode'];
        }

        if (!session::logged_in()) {

            if (!isset($mode) || ($mode != ALL_DISCUSSIONS && $mode != TODAYS_DISCUSSIONS && $mode != TWO_DAYS_BACK && $mode != SEVEN_DAYS_BACK)) {
                $mode = ALL_DISCUSSIONS;
            }

        } else {

            $threads_any_unread = threads_any_unread();

            if (isset($mode) && is_numeric($mode)) {

                $_SESSION['THREAD_MODE'] = $mode;

            } else {

                if (isset($_SESSION['THREAD_MODE']) && is_numeric($_SESSION['THREAD_MODE'])) {
                    $mode = $_SESSION['THREAD_MODE'];
                } else {
                    $mode = UNREAD_DISCUSSIONS;
                }

                if ($mode == UNREAD_DISCUSSIONS && !$threads_any_unread) {
                    $mode = ALL_DISCUSSIONS;
                }
            }
        }

        if (browser_mobile()) {

            light_html_draw_top(
                array(
                    'js' => array(
                        'js/thread_list.js'
                    )
                )
            );
        }

        if (forums_get_available_count() > 1 || !forum_get_default()) {

            light_navigation_bar(
                array(
                    'back' => "lforums.php?webtag=$webtag",
                )
            );

        } else {

            light_navigation_bar();
        }

        light_draw_thread_list($mode, $folder, $start_from);
    }

} else {

    if (browser_mobile()) {
        light_html_draw_top();
    }

    light_navigation_bar();

    light_draw_my_forums();
}

if (!browser_mobile() && !session::is_search_engine()) {

    echo "</div>\n";
    echo "</body>\n";
    echo "</noframes>\n";
    echo "</frameset>\n";

    html_draw_bottom(true);

} else {

    light_html_draw_bottom();
}