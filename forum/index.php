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

// Includes required by this page.
require_once BH_INCLUDE_PATH. 'browser.inc.php';
require_once BH_INCLUDE_PATH. 'cache.inc.php';
require_once BH_INCLUDE_PATH. 'constants.inc.php';
require_once BH_INCLUDE_PATH. 'folder.inc.php';
require_once BH_INCLUDE_PATH. 'header.inc.php';
require_once BH_INCLUDE_PATH. 'html.inc.php';
require_once BH_INCLUDE_PATH. 'lang.inc.php';
require_once BH_INCLUDE_PATH. 'light.inc.php';
require_once BH_INCLUDE_PATH. 'logon.inc.php';
require_once BH_INCLUDE_PATH. 'messages.inc.php';
require_once BH_INCLUDE_PATH. 'pm.inc.php';
require_once BH_INCLUDE_PATH. 'session.inc.php';
require_once BH_INCLUDE_PATH. 'threads.inc.php';
require_once BH_INCLUDE_PATH. 'user.inc.php';

// Don't cache this page
cache_disable();

if (isset($_GET['view']) && ($_GET['view'] == 'full')) {

    html_set_cookie('view', 'full');
    header_redirect('index.php');

} else if (isset($_GET['view']) && ($_GET['view'] == 'mobile')) {

    html_set_cookie('view', 'mobile');
    header_redirect('index.php');
}

lang_init();

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
                $final_uri = "admin.php?webtag=$webtag&amp;page=$final_uri";

            } else if (preg_match("/^$my_controls_preg/u", $final_uri) > 0) {

                $final_uri = rawurlencode(href_cleanup_query_keys($final_uri));
                $final_uri = "user.php?webtag=$webtag&amp;page=$final_uri";
            }
        }
    }

    html_draw_top('frame_set_html', 'pm_popup_disabled', 'robots=index,follow');

    if (isset($_SESSION['FONT_SIZE']) && is_numeric($_SESSION['FONT_SIZE'])) {
        $navsize = max(max(min($_SESSION['FONT_SIZE'], 15), 5) * 2, 22);
    } else {
        $navsize = 22;
    }

    if (forum_check_webtag_available($webtag)) {

        if (!isset($final_uri)) {

            if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

                $final_uri = "discussion.php?webtag=$webtag&amp;msg={$_GET['msg']}";

            } else if (isset($_GET['folder']) && is_numeric($_GET['folder'])) {

                $final_uri = "discussion.php?webtag=$webtag&amp;folder={$_GET['folder']}";

            } else if (isset($_GET['pmid']) && is_numeric($_GET['pmid'])) {

                $final_uri = "pm.php?webtag=$webtag&amp;mid={$_GET['pmid']}";

            } else {

                if (isset($_SESSION['START_PAGE']) && is_numeric($_SESSION['START_PAGE'])) {

                    if ($_SESSION['START_PAGE'] == START_PAGE_MESSAGES) {
                        $final_uri = "discussion.php?webtag=$webtag";
                    } else if ($_SESSION['START_PAGE'] == START_PAGE_INBOX) {
                        $final_uri = "pm.php?webtag=$webtag";
                    } else if ($_SESSION['START_PAGE'] == START_PAGE_THREAD_LIST) {
                        $final_uri = "start.php?webtag=$webtag&amp;left=threadlist";
                    } else {
                        $final_uri = "start.php?webtag=$webtag";
                    }

                } else {

                    $final_uri = "start.php?webtag=$webtag";
                }
            }
        }

    } else {

        if (get_webtag()) {

            if (isset($final_uri) && strlen(trim($final_uri)) > 0) {

                $final_uri = sprintf("forums.php?webtag=$webtag&amp;webtag_error=true&amp;final_uri=%s", rawurlencode($final_uri));

            } else if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

                $final_uri = "forums.php?webtag=$webtag&amp;webtag_error=true&amp;final_uri=discussion.php%3Fmsg%3D{$_GET['msg']}";

            } else if (isset($_GET['folder']) && is_numeric($_GET['folder'])) {

                $final_uri = "forums.php?webtag=$webtag&amp;webtag_error=true&amp;final_uri=discussion.php%3Ffolder%3D{$_GET['folder']}";

            } else if (isset($_GET['pmid']) && is_numeric($_GET['pmid'])) {

                $final_uri = "forums.php?webtag=$webtag&amp;webtag_error=true&amp;final_uri=pm.php%3Fmid%3D{$_GET['pmid']}";

            } else {

                $final_uri = "forums.php?webtag=$webtag&amp;webtag_error=true";
            }

        } else {

            $final_uri = "forums.php";
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

} else {

    light_html_draw_top();
}

if (forum_check_webtag_available($webtag)) {

    if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

        list($tid, $pid) = explode('.', $_GET['msg']);

        light_draw_messages($tid, $pid);

    } else if (isset($_GET['pmid']) && is_numeric($_GET['pmid'])) {

        if (!session::logged_in()) {
            light_html_guest_error();
        }

        light_pm_enabled();

        pm_user_prune_folders();

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

        light_draw_thread_list($mode, $folder, $start_from);
    }

} else {

    light_draw_my_forums();
}

if (!browser_mobile() && !session::is_search_engine()) {

    echo "</body>\n";
    echo "</noframes>\n";
    echo "</frameset>\n";

    html_draw_bottom(true);

} else {

    light_html_draw_bottom();
}

?>