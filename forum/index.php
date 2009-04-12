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

/* $Id: index.php,v 1.194 2009-04-12 17:15:57 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

// This page doesn't validate as XHTML Frameset, but I don't care.

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Disable PHP's register_globals
unregister_globals();

// Set the default timezone
date_default_timezone_set('UTC');

// Compress the output
include_once(BH_INCLUDE_PATH. "gzipenc.inc.php");

// Enable the error handler
include_once(BH_INCLUDE_PATH. "errorhandler.inc.php");

// Installation checking functions
include_once(BH_INCLUDE_PATH. "install.inc.php");

// Check that Beehive is installed correctly
check_install();

//Multiple forum support
include_once(BH_INCLUDE_PATH. "forum.inc.php");

// Fetch Forum Settings

$forum_settings = forum_get_settings();

// Fetch Global Forum Settings

$forum_global_settings = forum_get_global_settings();

include_once(BH_INCLUDE_PATH. "compat.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "light.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "messages.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");

// Embedded light mode in this script.

define('BEEHIVE_LIGHT_INCLUDE', true);

// Don't cache this page - fixes problems with Opera.

cache_disable();

// See if we can try and logon automatically

logon_perform_auto();

// Load the user session

$user_sess = bh_session_check(false);

// Check to see if the user is banned.

if (bh_session_user_banned()) {

    html_user_banned();
    exit;
}

// Get webtag

$webtag = get_webtag();

// Check the webtag is valid. Don't redirect.

forum_check_webtag_available($webtag);

// Check to see if we have an active session

$session_active = bh_session_active();

// Check for login failure.

if (isset($_GET['logon_failed'])) {
    $logon_failed = '&amp;logon_failed=true';
}else {
    $logon_failed = false;
}

// Check for log out notification.

if (isset($_GET['logout_success'])) {
    $logout_success = '&amp;logout_success=true';
}else {
    $logout_success = false;
}

// Check for other logon button click

if (isset($_GET['other_logon'])) {
    $other_logon = '&amp;other_logon=true';
}else {
    $other_logon = false;
}

// Check to see if the user is trying to change their password.

$skip_logon_page = false;

// Check to see if noframes URL query specified

light_mode_check_noframes();

// Load language file

$lang = lang::get_instance()->load(__FILE__);

// Top frame filename

$top_html = html_get_top_page();

// Clear the logon cookie

bh_setcookie("bh_logon", "", time() - YEAR_IN_SECONDS);

// Are we being redirected somewhere?

if (isset($_GET['final_uri']) && strlen(trim(stripslashes_array($_GET['final_uri']))) > 0) {

    $final_uri_check = basename(trim(stripslashes_array($_GET['final_uri'])));

    $available_files = get_available_files();
    $available_files_preg = implode("|^", array_map('preg_quote_callback', $available_files));

    $available_admin_files = get_available_admin_files();
    $available_admin_files_preg = implode("|^", array_map('preg_quote_callback', $available_admin_files));

    $my_controls_files = get_available_user_control_files();
    $my_controls_preg = implode("|^", array_map('preg_quote_callback', $my_controls_files));

    if (preg_match("/^$available_files_preg/u", $final_uri_check) > 0) {

        $final_uri = basename(trim(stripslashes_array($_GET['final_uri'])));

        if (preg_match("/^change_pw.php|^register.php|^confirm_email.php|^forgot_pw.php|^logout.php/u", $final_uri) > 0) {

            $final_uri = href_cleanup_query_keys($final_uri);
            $skip_logon_page = true;

        }else if (preg_match("/^$available_admin_files_preg/u", $final_uri) > 0) {

            $final_uri = rawurlencode(href_cleanup_query_keys($final_uri, false, '&'));
            $final_uri = "admin.php?webtag=$webtag&amp;page=$final_uri";

        }else if (preg_match("/^$my_controls_preg/u", $final_uri) > 0) {

            $final_uri = rawurlencode(href_cleanup_query_keys($final_uri, false, '&'));
            $final_uri = "user.php?webtag=$webtag&amp;page=$final_uri";
        }
    }
}

// Calculate how tall the nav frameset should be based on the user's fontsize.

$navsize = bh_session_get_value('FONT_SIZE');
$navsize = max((is_numeric($navsize) ? $navsize * 2 : 22), 22);

// Output starts here

html_draw_top('frame_set_html', 'pm_popup_disabled', 'robots=index,follow');

// If user has requested password change show the form instead of the logon page.

if ($skip_logon_page === true) {

    $frameset = new html_frameset_rows("60,$navsize,*");

    $frameset->html_frame($top_html, html_get_frame_name('ftop'), 0, 'no', 'noresize');
    $frameset->html_frame("nav.php?webtag=$webtag", html_get_frame_name('fnav'), 0, 'no', 'noresize');
    $frameset->html_frame($final_uri, html_get_frame_name('main'));

}else if ($session_active && $logon_failed === false) {

    if (forum_check_webtag_available($webtag)) {

        if (!isset($final_uri)) {

            if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

                $final_uri = "discussion.php?webtag=$webtag&amp;msg={$_GET['msg']}";

            }else if (isset($_GET['folder']) && is_numeric($_GET['folder'])) {

                $final_uri = "discussion.php?webtag=$webtag&amp;folder={$_GET['folder']}";

            }else if (isset($_GET['pmid']) && is_numeric($_GET['pmid'])) {

                $final_uri = "pm.php?webtag=$webtag&amp;mid={$_GET['pmid']}";

            }else {

                if (($start_page = bh_session_get_value('START_PAGE'))) {

                    if ($start_page == START_PAGE_MESSAGES) {
                        $final_uri = "discussion.php?webtag=$webtag";
                    }elseif ($start_page == START_PAGE_INBOX) {
                        $final_uri = "pm.php?webtag=$webtag";
                    }elseif ($start_page == START_PAGE_THREAD_LIST) {
                        $final_uri = "start.php?webtag=$webtag&amp;left=threadlist";
                    }else {
                        $final_uri = "start.php?webtag=$webtag";
                    }

                }else {

                    $final_uri = "start.php?webtag=$webtag";
                }
            }
        }

    }else {

        if (get_webtag()) {

            if (isset($final_uri) && strlen(trim($final_uri)) > 0) {

                $final_uri = sprintf("forums.php?webtag=$webtag&amp;webtag_error=true&amp;final_uri=%s", rawurlencode($final_uri));

            }else if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

                $final_uri = "forums.php?webtag=$webtag&amp;webtag_error=true&amp;final_uri=discussion.php%3Fmsg%3D{$_GET['msg']}";

            }else if (isset($_GET['folder']) && is_numeric($_GET['folder'])) {

                $final_uri = "forums.php?webtag=$webtag&amp;webtag_error=true&amp;final_uri=discussion.php%3Ffolder%3D{$_GET['folder']}";

            }else if (isset($_GET['pmid']) && is_numeric($_GET['pmid'])) {

                $final_uri = "forums.php?webtag=$webtag&amp;webtag_error=true&amp;final_uri=pm.php%3Fmid%3D{$_GET['pmid']}";

            }else {

                $final_uri = "forums.php?webtag=$webtag&amp;webtag_error=true";
            }

        }else {

            $final_uri = "forums.php";
        }
    }

    $frameset = new html_frameset_rows("60,$navsize,*");
    $frameset->html_frame($top_html, html_get_frame_name('ftop'), 0, 'no', 'noresize');
    $frameset->html_frame("nav.php?webtag=$webtag", html_get_frame_name('fnav'), 0, 'no', 'noresize');
    $frameset->html_frame($final_uri, html_get_frame_name('main'));

}else {

    if (isset($final_uri) && strlen($final_uri) > 0) {

        $final_uri = sprintf("logon.php?webtag=$webtag$other_logon$logout_success$logon_failed&amp;final_uri=%s", rawurlencode($final_uri));

    }elseif (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

        $final_uri = "logon.php?webtag=$webtag$other_logon$logout_success$logon_failed&amp;final_uri=discussion.php%3Fwebtag%3D$webtag%26msg%3D{$_GET['msg']}";

    }else if (isset($_GET['folder']) && is_numeric($_GET['folder'])) {

        $final_uri = "logon.php?webtag=$webtag$other_logon&amp;$logout_success$logon_failed&amp;final_uri=discussion.php%3Fwebtag%3D$webtag%26folder%3D{$_GET['folder']}";

    }else if (isset($_GET['pmid']) && is_numeric($_GET['pmid'])) {

        $final_uri = "logon.php?webtag=$webtag$other_logon$logout_success$logon_failed&amp;final_uri=pm.php%3Fwebtag%3D$webtag%26mid={$_GET['pmid']}";

    }else {

        $final_uri = "logon.php?webtag=$webtag$other_logon$logout_success$logon_failed";
    }

    $frameset = new html_frameset_rows("60,*");
    $frameset->html_frame($top_html, html_get_frame_name('ftop'), 0, 'no', 'noresize');
    $frameset->html_frame($final_uri, html_get_frame_name('main'));
}

$frameset->output_html(false);

echo "<noframes>\n";
echo "<body>\n";

if ($session_active && $logon_failed === false) {

    if (forum_check_webtag_available($webtag)) {

        if (isset($_GET['msg']) && validate_msg($_GET['msg'])) {

            $msg = $_GET['msg'];

            light_draw_messages($msg);
                      
        }else if (isset($_GET['pmid']) && is_numeric($_GET['pmid'])) {
        
            // Guests can't access PMs

            if (user_is_guest()) {

                light_html_guest_error();
                exit;
            }

            // Check that PM system is enabled

            light_pm_enabled();        
        
            pm_user_prune_folders();

            light_draw_pm_inbox();
            
        }else {
           
            light_draw_thread_list();
        }

    }else {

        light_draw_my_forums();

        echo "<h4><a href=\"llogout.php?webtag=$webtag\">{$lang['logout']}</a></h4>\n";
    }

}else {

    light_draw_logon_form();
}

echo "<h6>&copy; ", date('Y'), " <a href=\"http://www.beehiveforum.net/\" target=\"_blank\">Project Beehive Forum</a></h6>\n";
echo "</body>\n";
echo "</noframes>\n";
echo "</frameset>\n";

html_draw_bottom(true);

?>