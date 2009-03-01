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

/* $Id: lpm.php,v 1.2 2009-03-01 16:28:00 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

// Light Mode Detection
define("BEEHIVEMODE_LIGHT", true);

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Disable PHP's register_globals
unregister_globals();

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

include_once(BH_INCLUDE_PATH. "compat.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "fixhtml.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "light.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "pm.inc.php");
include_once(BH_INCLUDE_PATH. "post.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");
include_once(BH_INCLUDE_PATH. "word_filter.inc.php");
include_once(BH_INCLUDE_PATH. "zip_lib.inc.php");

// Get Webtag

$webtag = get_webtag();

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
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

// Load language file

$lang = lang::get_instance()->load(__FILE__);

// Get the user's UID

$uid = bh_session_get_value('UID');

// Guests can't access PMs

if (user_is_guest()) {

    light_html_guest_error();
    exit;
}

// Check that PM system is enabled

light_pm_enabled();

// Get custom folder names array.

if (!$pm_folder_names_array = pm_get_folder_names()) {

    $pm_folder_names_array = array(PM_FOLDER_INBOX   => $lang['pminbox'],
                                   PM_FOLDER_SENT    => $lang['pmsentitems'],
                                   PM_FOLDER_OUTBOX  => $lang['pmoutbox'],
                                   PM_FOLDER_SAVED   => $lang['pmsaveditems'],
                                   PM_FOLDER_DRAFTS  => $lang['pmdrafts']);
}

// Prune old messages for the current user

pm_user_prune_folders();

// Draw the header.

light_html_draw_top();

// Check to see which page we should be on

if (isset($_GET['start_from']) && is_numeric($_GET['start_from'])) {
    $start_from = $_GET['start_from'];
}else if (isset($_POST['start_from']) && is_numeric($_POST['start_from'])) {
    $start_from = $_POST['start_from'];
}else {
    $start_from = 0;
}

// Check to see if we're viewing a message and get the folder it is in.

if (isset($_GET['mid']) && is_numeric($_GET['mid'])) {

    $mid = ($_GET['mid'] > 0) ? $_GET['mid'] : 0;
    
    if (!$message_folder = pm_message_get_folder($mid)) {
        $message_folder = PM_FOLDER_INBOX;
    }    

}elseif (isset($_POST['mid']) && is_numeric($_POST['mid'])) {

    $mid = ($_POST['mid'] > 0) ? $_POST['mid'] : 0;
    
    if (!$message_folder = pm_message_get_folder($mid)) {
        $message_folder = PM_FOLDER_INBOX;
    }
}

$current_folder = false;

if (isset($_GET['folder'])) {

    if ($_GET['folder'] == PM_FOLDER_INBOX) {
        $current_folder = PM_FOLDER_INBOX;
    }else if ($_GET['folder'] == PM_FOLDER_SENT) {
        $current_folder = PM_FOLDER_SENT;
    }else if ($_GET['folder'] == PM_FOLDER_OUTBOX) {
        $current_folder = PM_FOLDER_OUTBOX;
    }else if ($_GET['folder'] == PM_FOLDER_SAVED) {
        $current_folder = PM_FOLDER_SAVED;
    }else if ($_GET['folder'] == PM_FOLDER_DRAFTS) {
        $current_folder = PM_FOLDER_DRAFTS;
    }

}elseif (isset($_POST['folder'])) {

    if ($_POST['folder'] == PM_FOLDER_INBOX) {
        $current_folder = PM_FOLDER_INBOX;
    }else if ($_POST['folder'] == PM_FOLDER_SENT) {
        $current_folder = PM_FOLDER_SENT;
    }else if ($_POST['folder'] == PM_FOLDER_OUTBOX) {
        $current_folder = PM_FOLDER_OUTBOX;
    }else if ($_POST['folder'] == PM_FOLDER_SAVED) {
        $current_folder = PM_FOLDER_SAVED;
    }else if ($_POST['folder'] == PM_FOLDER_DRAFTS) {
        $current_folder = PM_FOLDER_DRAFTS;
    }
}

if (isset($mid) && is_numeric($mid) && $mid > 0) {

    if (($current_folder != $message_folder)) {

        light_html_draw_top('pm_popup_disabled');
        light_html_display_error_msg($lang['messagenotfoundinselectedfolder']);
        light_html_draw_bottom();
        exit;
    }

    if (!$pm_message_array = pm_message_get($mid)) {

        light_html_draw_top('pm_popup_disabled');
        light_html_display_error_msg($lang['messagehasbeendeleted']);
        light_html_draw_bottom();
        exit;
    }
    
    echo "<h1>{$lang['privatemessages']} &raquo; {$pm_folder_names_array[$current_folder]}</h1>\n";
    
    if (isset($pm_message_array) && is_array($pm_message_array)) {
    
        $pm_message_array['CONTENT'] = pm_get_content($mid);
    
        light_pm_display($pm_message_array, $message_folder);
        
        echo "<h4><a href=\"lpm.php?webtag=DEFAULT&amp;folder=$current_folder\">{$lang['back']}</a> | <a href=\"llogout.php?webtag=DEFAULT\">{$lang['logout']}</a></h4>\n";
    }
    
}else {

    echo "<h1>{$lang['privatemessages']}</h1>\n";

    $pm_message_count_array = pm_get_folder_message_counts();

    echo "<p>";

    foreach ($pm_folder_names_array as $folder_type => $folder_name) {

        if (isset($pm_message_count_array[$folder_type]) && is_numeric($pm_message_count_array[$folder_type])) {

            echo "<h3><a href=\"lpm.php?webtag=$webtag&amp;folder=$folder_type\">$folder_name</a></h3>\n";
            echo "<p>{$pm_message_count_array[$folder_type]} {$lang['messages']}</p>\n";
            
            if (isset($current_folder) && ($current_folder == $folder_type)) {
            
                if ($current_folder == PM_FOLDER_INBOX) {
            
                    $pm_messages_array = pm_get_inbox(false, false, $start_from, 20);
            
                }elseif ($current_folder == PM_FOLDER_SENT) {
            
                    $pm_messages_array = pm_get_sent(false, false, $start_from, 20);
            
                }elseif ($current_folder == PM_FOLDER_OUTBOX) {
            
                    $pm_messages_array = pm_get_outbox(false, false, $start_from, 20);
            
                }elseif ($current_folder == PM_FOLDER_SAVED) {
            
                    $pm_messages_array = pm_get_saved_items(false, false, $start_from, 20);
            
                }elseif ($current_folder == PM_FOLDER_DRAFTS) {
            
                    $pm_messages_array = pm_get_drafts(false, false, $start_from, 20);
                }
                                
                if (isset($pm_messages_array['message_array']) && sizeof($pm_messages_array['message_array']) > 0) {
            
                    if ($start_from > 0) {
                        echo "<p><a href=\"lpm.php?webtag=$webtag&amp;folder=$current_folder&amp;start_from=", ($start_from - 20), "\"><b>{$lang['prev']}</b></a></p>\n";
                    }
                    
                    echo "<ul>\n";
                    
                    foreach ($pm_messages_array['message_array'] as $message) {
                        
                        if ($message['TYPE'] == PM_UNREAD) {
                        
                            echo "<li><a href=\"lpm.php?webtag=$webtag&amp;folder=$current_folder&amp;mid={$message['MID']}\" title=\"{$message['SUBJECT']}\"><b>{$message['SUBJECT']}</b></a> ", ($message['TYPE'] == PM_UNREAD) ? "<b>[U]</b> " : "[R] ", format_time($message['CREATED']), "</li>\n";
                        
                        }else {
                        
                            echo "<li><a href=\"lpm.php?webtag=$webtag&amp;folder=$current_folder&amp;mid={$message['MID']}\" title=\"{$message['SUBJECT']}\">{$message['SUBJECT']}</a> ", ($message['TYPE'] == PM_UNREAD) ? "<b>[U]</b> " : "[R] ", format_time($message['CREATED']), "</li>\n";
                        }
                    }
                    
                    echo "</ul>\n";
                    
                    $more_messages = $pm_message_count_array[$folder_type] - $start_from - 20;
                    
                    if ($more_messages > 0) {
                        echo "<p><a href=\"lpm.php?webtag=$webtag&amp;folder=$current_folder&amp;start_from=", ($start_from + 20), "\"><b>{$lang['next']}</b></a></p>\n";
                    }
                }
            }
        }
    }

    echo "</p>\n";
    echo "<p><b><a href=\"lpm_write.php?webtag=$webtag\" title=\"{$lang['sendnewpm']}\">{$lang['sendnewpm']}</a></b></p>\n";

    // Fetch the free PM space and calculate it as a percentage.

    $pm_free_space = pm_get_free_space();
    $pm_max_user_messages = forum_get_setting('pm_max_user_messages', false, 100);

    $pm_used_percent = (100 / $pm_max_user_messages) * ($pm_max_user_messages - $pm_free_space);

    echo "<p>", sprintf($lang['yourpmfoldersare'], "$pm_used_percent%"), "</p>\n";

    if (pm_auto_prune_enabled()) {
        echo "<p>{$lang['pmfolderpruningisenabled']}</p>\n";
    }
    
    echo "<h4><a href=\"lthread_list.php?webtag=$webtag\">{$lang['backtothreadlist']}</a> | <a href=\"llogout.php?webtag=$webtag\">{$lang['logout']}</a></h4>\n";
}

light_html_draw_bottom();

?>