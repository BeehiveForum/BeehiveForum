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

/* $Id: json.php 4599 2010-11-16 20:00:49Z DecoyDuck $ */

// Set the default timezone
date_default_timezone_set('UTC');

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Caching functions
include_once(BH_INCLUDE_PATH. "cache.inc.php");

// Disable PHP's register_globals
unregister_globals();

// Correctly set server protocol
set_server_protocol();

// Disable caching if on AOL
cache_disable_aol();

// Disable caching if proxy server detected.
cache_disable_proxy();

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

include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

// Don't cache this page
cache_disable();

// Get webtag
$webtag = get_webtag();

// Start User Session.
$user_sess = session_check();;

// Get the User's UID
$uid = session_get_value('UID');

// Check this is an ajax request and we have an action.
if (!isset($_GET['ajax']) || !isset($_GET['action'])) {
    header(sprintf("%s 500 Internal server error", $_SERVER['SERVER_PROTOCOL']));
}

// Switch on the action
switch ($_GET['action']) {
    
    // User autocomplete.
    case 'user_autocomplete':
    
        // Check we have a search query.
        if (!isset($_GET['q']) && strlen(trim($_GET['q'])) > 0) {
            header(sprintf("%s 500 Internal server error", $_SERVER['SERVER_PROTOCOL']));
        } 
            
        // Clean up the query.
        $query = trim(stripslashes_array($_GET['q']));
        
        // Get the search results.
        if (!$search_results_array = user_search($query)) {
            header(sprintf("%s 500 Internal server error", $_SERVER['SERVER_PROTOCOL']));
        }
        
        // JSON encode the results to return.
        foreach ($search_results_array['results_array'] as $search_result) {
            echo json_encode(array_intersect_key($search_result, array_flip(array('LOGON', 'NICKNAME')))), "\n";
        } 
        
        break;
        
    case 'sig_toggle':
    
        // Get the user's post page preferences.
        $page_prefs = session_get_post_page_prefs();
        
        // Get the hide state from the request.
        if (!isset($_GET['display']) || !in_array($_GET['display'], array('true', 'false'))) {
            header(sprintf("%s 500 Internal server error", $_SERVER['SERVER_PROTOCOL']));
        }
        
        // Don't rely on switching the bit, always check the client
        // request in case the interface is out of sync with the database.
        if ($_GET['display'] === 'true') {
            $page_prefs = (double)$page_prefs | POST_SIGNATURE_DISPLAY;
        } else {
            $page_prefs = (double)$page_prefs ^ ($page_prefs & POST_SIGNATURE_DISPLAY);
        }
        
        // Set the user_prefs array entry to pass to user_update_prefs
        $user_prefs = array('POST_PAGE' => $page_prefs);

        // Save the user prefs.
        if (!user_update_prefs($uid, $user_prefs)) {
            header(sprintf("%s 500 Internal server error", $_SERVER['SERVER_PROTOCOL']));
        }

        break;            
        
    case 'emots_toggle':
    
        // Get the user's post page preferences.
        $page_prefs = session_get_post_page_prefs();
        
        // Get the hide state from the request.
        if (!isset($_GET['display']) || !in_array($_GET['display'], array('true', 'false'))) {
            header(sprintf("%s 500 Internal server error", $_SERVER['SERVER_PROTOCOL']));
        }
        
        // Don't rely on switching the bit, always check the client
        // request in case the interface is out of sync with the database.
        if ($_GET['display'] === 'true') {
            $page_prefs = (double)$page_prefs | POST_EMOTICONS_DISPLAY;
        } else {
            $page_prefs = (double)$page_prefs ^ ($page_prefs & POST_EMOTICONS_DISPLAY);
        }        
        
        // Set the user_prefs array entry to pass to user_update_prefs
        $user_prefs = array('POST_PAGE' => $page_prefs);

        // Save the user prefs.
        if (!user_update_prefs($uid, $user_prefs)) {
            header(sprintf("%s 500 Internal server error", $_SERVER['SERVER_PROTOCOL']));
        }

        break;        
        
    case 'poll_advanced_toggle':
    
        // Get the user's post page preferences.
        $page_prefs = session_get_post_page_prefs();
        
        // Get the hide state from the request.
        if (!isset($_GET['display']) || !in_array($_GET['display'], array('true', 'false'))) {
            header(sprintf("%s 500 Internal server error", $_SERVER['SERVER_PROTOCOL']));
        }
        
        // Don't rely on switching the bit, always check the client
        // request in case the interface is out of sync with the database.
        if ($_GET['display'] === 'true') {
            $page_prefs = (double)$page_prefs | POLL_ADVANCED_DISPLAY;
        } else {
            $page_prefs = (double)$page_prefs ^ ($page_prefs & POLL_ADVANCED_DISPLAY);
        }        
        
        // Set the user_prefs array entry to pass to user_update_prefs
        $user_prefs = array('POST_PAGE' => $page_prefs);

        // Save the user prefs.
        if (!user_update_prefs($uid, $user_prefs)) {
            header(sprintf("%s 500 Internal server error", $_SERVER['SERVER_PROTOCOL']));
        }

        break;
                
    case 'poll_additional_message_toggle':
    
        // Get the user's post page preferences.
        $page_prefs = session_get_post_page_prefs();
        
        // Get the hide state from the request.
        if (!isset($_GET['display']) || !in_array($_GET['display'], array('true', 'false'))) {
            header(sprintf("%s 500 Internal server error", $_SERVER['SERVER_PROTOCOL']));
        }
        
        // Don't rely on switching the bit, always check the client
        // request in case the interface is out of sync with the database.
        if ($_GET['display'] === 'true') {
            $page_prefs = (double)$page_prefs | POLL_ADDITIONAL_MESSAGE_DISPLAY;
        } else {
            $page_prefs = (double)$page_prefs ^ ($page_prefs & POLL_ADDITIONAL_MESSAGE_DISPLAY);
        }        
        
        // Set the user_prefs array entry to pass to user_update_prefs
        $user_prefs = array('POST_PAGE' => $page_prefs);

        // Save the user prefs.
        if (!user_update_prefs($uid, $user_prefs)) {
            header(sprintf("%s 500 Internal server error", $_SERVER['SERVER_PROTOCOL']));
        }

        break;            
    
    // Unknown action
    default:
    
        header(sprintf("%s 500 Internal server error", $_SERVER['SERVER_PROTOCOL']));
        break;
}
  
?>