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

include_once(BH_INCLUDE_PATH. "cache.inc.php");
include_once(BH_INCLUDE_PATH. "compat.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");

// Get Webtag

$webtag = get_webtag();

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("logon.php?webtag=$webtag&final_uri=$request_uri");
}

// Check to see if the user is banned.

if (bh_session_user_banned()) exit;

// Check to see if the user has been approved.

if (!bh_session_user_approved()) exit;

// Guests can't do different font sizes.

if (user_is_guest()) exit;

// User's UID

$uid = bh_session_get_value('UID');

// User's MD5 Session Hash

$sess_hash = bh_session_get_value('HASH');

// User's font size.

if (($font_size = bh_session_get_value('FONT_SIZE')) === false) {
    $font_size = 10;
}

// Make sure the font size is positive and an integer.

$font_size = floor(abs($font_size));

// Output in text/css.

header("Content-Type: text/css");

// Check the cache

cache_check_etag(md5(sprintf("%s-%s-%s", $sess_hash, $font_size, $uid)));

// Check the user's font size.

if ($font_size < 5) $font_size = 5;
if ($font_size > 15) $font_size = 15;

// Array of different font sizes

$css_selectors = array('body'                          => array(10, 'pt'),
                       '.navpage'                      => array(10, 'px'),
                       '.forumlinks'                   => array(10, 'pt'),
                       'p'                             => array(10, 'pt'),
                       'h1'                            => array(10, 'pt'),
                       'h2'                            => array(10, 'pt'),
                       '.smalltext'                    => array(9, 'pt'),
                       '.thread_list_mode'             => array(10, 'pt'),
                       '.threads'                      => array(10, 'pt'),
                       '.threads_left'                 => array(10, 'pt'),
                       '.threads_right'                => array(10, 'pt'),
                       '.threads_top_left'             => array(10, 'pt'),
                       '.threads_top_right'            => array(10, 'pt'),
                       '.threads_bottom_left'          => array(10, 'pt'),
                       '.threads_bottom_right'         => array(10, 'pt'),
                       '.threads_left_right'           => array(10, 'pt'),
                       '.threads_left_right_bottom'    => array(10, 'pt'),
                       '.threads_top_left_bottom'      => array(10, 'pt'),
                       '.threads_top_right_bottom'     => array(10, 'pt'),
                       '.folderinfo'                   => array(8, 'pt'),
                       '.folderpostnew'                => array(8, 'pt'),
                       '.threadname'                   => array(10, 'pt'),
                       '.threadtime'                   => array(8, 'pt'),
                       '.threadxnewofy'                => array(8, 'pt'),
                       '.foldername'                   => array(10, 'pt'),
                       '.posthead'                     => array(10, 'pt'),
                       '.pmheadl'                      => array(10, 'pt'),
                       '.pmheadr'                      => array(10, 'pt'),
                       '.pm_message_count'             => array(8, 'pt'),
                       '.postbody'                     => array(10, 'pt'),
                       '.postnumber'                   => array(10, 'pt'),
                       '.postinfo'                     => array(10, 'pt'),
                       '.posttofromlabel'              => array(10, 'pt'),
                       '.posttofrom'                   => array(10, 'pt'),
                       '.postresponse'                 => array(10, 'pt'),
                       '.messagefoot'                  => array(10, 'pt'),
                       '.dictionary_button'            => array(9, 'pt'),
                       '.button'                       => array(9, 'pt'),
                       '.button_disabled'              => array(9, 'pt'),
                       '.smallbutton'                  => array(8, 'pt'),
                       '.subhead'                      => array(10, 'pt'),
                       '.bhinputtext'                  => array(9, 'pt'),
                       '.bhtextarea'                   => array(9, 'pt'),
                       '.bhselect'                     => array(9, 'pt'),
                       '.install_dropdown'             => array(9, 'pt'),
                       '.bhinputlogon'                 => array(9, 'pt'),
                       '.bhlogondropdown'              => array(9, 'pt'),
                       '.register_dropdown'            => array(9, 'pt'),
                       '.search_dropdown'              => array(9, 'pt'),
                       '.banned_dropdown'              => array(9, 'pt'),
                       '.links_dropdown'               => array(9, 'pt'),
                       '.timezone_dropdown'            => array(9, 'pt'),
                       '.admin_startpage_textarea'     => array(9, 'pt'),
                       '.dictionary_word_display'      => array(9, 'pt'),
                       '.dictionary_best_selection'    => array(9, 'pt'),
                       '.dictionary_change_to'         => array(9, 'pt'),
                       '.post_folder_dropdown'         => array(9, 'pt'),
                       '.thread_title'                 => array(9, 'pt'),
                       '.post_content'                 => array(9, 'pt'),
                       '.signature_content'            => array(9, 'pt'),
                       '.edit_signature_content'       => array(9, 'pt'),
                       '.to_uid_dropdown'              => array(9, 'pt'),
                       '.recipient_dropdown'           => array(9, 'pt'),
                       '.recent_user_dropdown'         => array(9, 'pt'),
                       '.admin_options_dropdown'       => array(9, 'pt'),
                       '.user_in_thread_dropdown'      => array(9, 'pt'),
                       '.user_pref_field'              => array(9, 'pt'),
                       '.bhinputprofileitem'           => array(9, 'pt'),
                       '.text_captcha_input'           => array(9, 'pt'),
                       '.user_pref_dob_dropdown'       => array(9, 'pt'),
                       '.user_pref_dropdown'           => array(9, 'pt'),
                       '.bhselectoptgroup'             => array(9, 'pt'),
                       '.bhselectoptgroup'             => array(9, 'pt'),
                       '.bhinputcheckbox'              => array(8, 'pt'),
                       '.bhinputradio'                 => array(8, 'pt'),
                       '.quotetext'                    => array(8, 'pt'),
                       '.activeusers'                  => array(8, 'pt'),
                       '.adminipdisplay'               => array(8, 'pt'),
                       '.pmnewcount'                   => array(8, 'pt'),
                       '.pmbar_text'                   => array(8, 'pt'),
                       '.pagenum_text'                 => array(8, 'pt'),
                       '.admin_settings_text'          => array(8, 'pt'),
                       '.post_to_others'               => array(9, 'pt'),
                       '.recipient_list'               => array(9, 'pt'),
                       '.search_input'                 => array(9, 'pt'),
                       '.merge_thread_id'              => array(9, 'pt'),
                       '.edit_text'                    => array(10, 'px'),
                       '.approved_text'                => array(10, 'px'),
                       '.subhead_sort_asc'             => array(10, 'pt'),
                       '.subhead_sort_desc'            => array(10, 'pt'),
                       '.subhead_checkbox'             => array(10, 'pt'),
                       '.profile_logon'                => array(10, 'pt'),
                       '.profile_item_name'            => array(9, 'pt'),
                       '.profile_item_value'           => array(9, 'pt'),
                       '.profile_item_value a'         => array(9, 'pt'),
                       '.image_resize_text'            => array(8, 'pt'),
                       '.forum_rules_box'              => array(9, 'pt'),
                       '.small_optional_text'          => array(7, 'pt'),
                       '.error_handler_details'        => array(9, 'pt'),
                       '.error_msg'                    => array(9, 'pt'),
                       '.success_msg'                  => array(9, 'pt'),
                       '.warning_msg'                  => array(9, 'pt'),
                       '.google_adsense_register_note' => array(7, 'pt'));

// Output the CSS

foreach ($css_selectors as $selector => $font_info) {
    printf("%s { font-size: %d%s; }\n", $selector, $font_size * ($font_info[0] / 10), $font_info[1]);
}

?>