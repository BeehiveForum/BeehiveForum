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

/* $Id$ */

// Set the default timezone
date_default_timezone_set('UTC');

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

// Disable PHP's register_globals
unregister_globals();

// Disable caching if on AOL
cache_disable_aol();

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

// Language include

include_once(BH_INCLUDE_PATH. "lang.inc.php");

// Don't cache this page

cache_disable();

// Get webtag

$webtag = get_webtag();

// Start User Session.

$user_sess = bh_session_check();

// User font size

if (($font_size = bh_session_get_value('FONT_SIZE')) === false) {
    $font_size = 10;
}

// Look for autocomplete search request

if (isset($_GET['search'])) {
    
    $search_results_array = array();
    
    if (isset($_GET['q']) && strlen(trim($_GET['q'])) > 0) {
        
        $query = trim(stripslashes_array($_GET['q']));
        
        $search_results_array = user_search($query);
        
        foreach ($search_results_array['results_array'] as $search_result) {
            
            echo json_encode(array_intersect_key($search_result, array_flip(array('LOGON', 'NICKNAME')))), "\n";
        } 
    }

} else {

    // Load the language file.

    $lang = load_language_file();

    // Required language strings. Add here the keys
    // of the required language strings to be returned
    // as the JSON response.

    $lang_required = array('fixhtmlexplanation',
                           'imageresized',
                           'deletemessagesconfirmation',
                           'unquote',
                           'quote',
                           'searchsuccessfullycompleted',
                           'confirmmarkasread');
                           
    // Construct the Javascript / JSON array

    $json_data = array('webtag'     => $webtag,
                       'uid'        => bh_session_get_value('UID'),
                       'lang'       => array_intersect_key($lang, array_flip($lang_required)),
                       'images'     => array(),
                       'font_size'  => $font_size,
                       'top_html'   => html_get_top_page(),
                       'user_style' => html_get_style_sheet(),
                       'emoticons'  => html_get_emoticon_style_sheet(),
                       'frames'     => array('index'       => html_get_frame_name('index'),
                                             'admin'       => html_get_frame_name('admin'),
                                             'start'       => html_get_frame_name('start'),
                                             'discussion'  => html_get_frame_name('discussion'),
                                             'user'        => html_get_frame_name('user'),
                                             'pm'          => html_get_frame_name('pm'),
                                             'main'        => html_get_frame_name('main'),
                                             'ftop'        => html_get_frame_name('ftop'),
                                             'fnav'        => html_get_frame_name('fnav'),
                                             'left'        => html_get_frame_name('left'),
                                             'right'       => html_get_frame_name('right'),
                                             'pm_folders'  => html_get_frame_name('pm_folders'),
                                             'pm_messages' => html_get_frame_name('pm_messages')));



    // Get all the style images

    foreach (glob("images/*.png") as $image_filename) {
        
        $image_filename = basename($image_filename);
        $json_data['images'][$image_filename] = style_image($image_filename);
    }

    // If the data is requested via JSON send the 
    // correct header and content.

    if (isset($_GET['json'])) {                       

        // JSON header

        header('Content-type: application/json; charset=UTF-8', true);

        // Output the JSON data.

        echo json_encode($json_data);

    } else {
        
        header('Content-type: text/javascript; charset=UTF-8', true);
        
        echo "beehive = $.extend({}, beehive, ", json_encode($json_data), ");\n";
        echo "$(document).ready(function() {\n";
        echo "  $(beehive).trigger('init');\n";
        echo "});";
    }
}

?>
