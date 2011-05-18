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

// Get webtag
$webtag = get_webtag();

// Start User Session.
$user_sess = session_check();

// User font size
if (($font_size = session_get_value('FONT_SIZE')) === false) {
    $font_size = 10;
}

// User style
if (($user_style = session_get_value('STYLE')) === false) {
    $user_style = html_get_cookie("forum_style", false, forum_get_setting('default_style', false, 'default'));
}

// Get the forum path
$forum_path = defined('BH_FORUM_PATH') ? rtrim(BH_FORUM_PATH, '/') : '.';

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
                       'confirmmarkasread',
                       'waitdotdotdot',
                       'more');

// Get the user's saved left frame width.
if (($left_frame_width = session_get_value('LEFT_FRAME_WIDTH')) === false) {
    $left_frame_width = 280;
}

// Construct the Javascript / JSON array
$json_data = array('webtag'            => $webtag,
                   'uid'               => session_get_value('UID'),
                   'lang'              => array_intersect_key($lang, array_flip($lang_required)),
                   'images'            => array(),
                   'font_size'         => $font_size,
                   'user_style'        => html_get_style_sheet(),
                   'emoticons'         => html_get_emoticon_style_sheet(),
                   'top_frame'         => html_get_top_page(),
                   'left_frame_width'  => $left_frame_width,
                   'forum_path'        => $forum_path,
                   'use_mover_spoiler' => session_get_value('USE_MOVER_SPOILER'),
                   'frames'            => array('index'       => html_get_frame_name('index'),
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

if (($images_array = glob("styles/$user_style/images/*.png"))) {

    foreach ($images_array as $image_filename) {

        $image_filename = basename($image_filename);
        $json_data['images'][$image_filename] = html_style_image($image_filename);
    }
}

// Decide on the correct Content-Type and encoding
// of the content. This allows Beehive to reload the
// JSON data via the same script, either for use
// in a <script> tag or via AJAX.
if (isset($_GET['json'])) {

    $content_type = 'application/json';

    $content = json_encode($json_data);

} else {

    $content_type = 'text/javascript';

    $content = sprintf('var beehive = $.extend({}, beehive, %s);
                        $(document).ready(function() {
                          $(beehive).trigger("init");
                        });', json_encode($json_data));
}

// Send correct Content-Type header
header(sprintf('Content-type: %s; charset=UTF-8', $content_type), true);

// Check the cache of the file.
cache_check_etag(md5($content_type. $content));

// Output the content
echo $content;

?>