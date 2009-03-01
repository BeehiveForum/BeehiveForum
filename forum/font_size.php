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

/* $Id: font_size.php,v 1.33 2009-03-01 15:51:23 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "include/");

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

if (bh_session_user_banned()) {

    html_user_banned();
    exit;
}

// Check to see if the user has been approved.

if (!bh_session_user_approved()) {

    html_user_require_approval();
    exit;
}

// Check we have a webtag

if (!forum_check_webtag_available($webtag)) {
    $request_uri = rawurlencode(get_request_uri(false));
    header_redirect("forums.php?webtag_error&final_uri=$request_uri");
}

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("forums.php?webtag_error&final_uri=$request_uri");
}

// Guests can't do different font sizes.

if (user_is_guest()) {
    exit;
}

// User's UID

$uid = bh_session_get_value('UID');

// User's MD5 Session Hash

$sess_hash = bh_session_get_value('HASH');

// User's font size.

$font_size = bh_session_get_value('FONT_SIZE');

// Output in text/css.

header("Content-Type: text/css");

// Generate etag for cache control

$local_etag = md5(sprintf("%s-%s-%s", $sess_hash, $font_size, $uid));

// Check the cache

header_check_etag($local_etag);

// Check the user's font size.

if (!is_bool($font_size) && is_numeric($font_size) && $font_size != 10) {

    if ($font_size < 5) $font_size = 5;
    if ($font_size > 15) $font_size = 15;

    echo "body                       { font-size: ", $font_size, "pt; }\n";
    echo ".navpage                   { font-size: ", floor($font_size * 0.9), "pt }\n";
    echo "p                          { font-size: ", $font_size, "pt; }\n";
    echo "h1                         { font-size: ", $font_size, "pt; }\n";
    echo "h2                         { font-size: ", $font_size, "pt; }\n";
    echo ".smalltext                 { font-size: ", floor($font_size * 0.9), "pt; }\n";
    echo ".thread_list_mode          { font-size: ", $font_size, "pt; }\n";
    echo ".threads                   { font-size: ", $font_size, "pt; }\n";
    echo ".threads_left              { font-size: ", $font_size, "pt; }\n";
    echo ".threads_right             { font-size: ", $font_size, "pt; }\n";
    echo ".threads_top_left          { font-size: ", $font_size, "pt; }\n";
    echo ".threads_top_right         { font-size: ", $font_size, "pt; }\n";
    echo ".threads_bottom_left       { font-size: ", $font_size, "pt; }\n";
    echo ".threads_bottom_right      { font-size: ", $font_size, "pt; }\n";
    echo ".threads_left_right        { font-size: ", $font_size, "pt; }\n";
    echo ".threads_left_right_bottom { font-size: ", $font_size, "pt; }\n";
    echo ".threads_top_left_bottom   { font-size: ", $font_size, "pt; }\n";
    echo ".threads_top_right_bottom  { font-size: ", $font_size, "pt; }\n";
    echo ".folderinfo                { font-size: ", floor($font_size * 0.9), "pt; }\n";
    echo ".folderpostnew             { font-size: ", floor($font_size * 0.9), "pt; }\n";
    echo ".threadname                { font-size: ", $font_size, "pt; }\n";
    echo ".threadtime                { font-size: ", floor($font_size * 0.9), "pt; }\n";
    echo ".threadxnewofy             { font-size: ", floor($font_size * 0.9), "pt; }\n";
    echo ".foldername                { font-size: ", $font_size, "pt; }\n";
    echo ".posthead                  { font-size: ", $font_size, "pt; }\n";
    echo ".pmheadl                   { font-size: ", $font_size, "pt; }\n";
    echo ".pmheadr                   { font-size: ", $font_size, "pt; }\n";
    echo ".postbody                  { font-size: ", $font_size, "pt; }\n";
    echo ".postinfo                  { font-size: ", $font_size, "pt; }\n";
    echo ".posttofromlabel           { font-size: ", $font_size, "pt; }\n";
    echo ".posttofrom                { font-size: ", $font_size, "pt; }\n";
    echo ".postresponse              { font-size: ", $font_size, "pt; }\n";
    echo ".messagefoot               { font-size: ", $font_size, "pt; }\n";
    echo ".dictionary_button         { font-size: ", floor($font_size * 0.9), "pt; }\n";
    echo ".button                    { font-size: ", floor($font_size * 0.9), "pt; }\n";
    echo ".button_disabled           { font-size: ", floor($font_size * 0.9), "pt; }\n";
    echo ".smallbutton               { font-size: ", floor($font_size * 0.9), "pt; }\n";
    echo ".subhead                   { font-size: ", $font_size, "pt; }\n";
    echo ".bhinputtext               { font-size: ", floor($font_size * 1.2), "pt; }\n";
    echo ".bhtextarea                { font-size: ", floor($font_size * 1.2), "pt; }\n";
    echo ".bhselect                  { font-size: ", floor($font_size * 0.9), "pt; }\n";
    echo ".bhinputcheckbox           { font-size: ", floor($font_size * 0.9), "pt; }\n";
    echo ".bhinputradio              { font-size: ", floor($font_size * 0.9), "pt; }\n";
    echo ".install_dropdown          { font-size: ", floor($font_size * 0.9), "pt; }\n";
    echo ".bhinputlogon              { font-size: ", floor($font_size * 0.9), "pt; }\n";
    echo ".bhlogondropdown           { font-size: ", floor($font_size * 0.9), "pt; }\n";
    echo ".register_dropdown         { font-size: ", floor($font_size * 0.9), "pt; }\n";
    echo ".search_dropdown           { font-size: ", floor($font_size * 0.9), "pt; }\n";
    echo ".banned_dropdown           { font-size: ", floor($font_size * 0.9), "pt; }\n";
    echo ".links_dropdown            { font-size: ", floor($font_size * 0.9), "pt; }\n";
    echo ".admin_startpage_textarea  { font-size: ", floor($font_size * 0.9), "pt; }\n";
    echo ".dictionary_word_display   { font-size: ", floor($font_size * 0.9), "pt; }\n";
    echo ".dictionary_best_selection { font-size: ", floor($font_size * 0.9), "pt; }\n";
    echo ".dictionary_change_to      { font-size: ", floor($font_size * 0.9), "pt; }\n";
    echo ".post_folder_dropdown      { font-size: ", floor($font_size * 0.9), "pt; }\n";
    echo ".thread_title              { font-size: ", floor($font_size * 0.9), "pt; }\n";
    echo ".post_to_others            { font-size: ", floor($font_size * 0.9), "pt; }\n";
    echo ".post_content              { font-size: ", floor($font_size * 0.9), "pt; }\n";
    echo ".signature_content         { font-size: ", floor($font_size * 0.9), "pt; }\n";
    echo ".to_uid_dropdown           { font-size: ", floor($font_size * 0.9), "pt; }\n";
    echo ".recipient_dropdown        { font-size: ", floor($font_size * 0.9), "pt; }\n";
    echo ".recipient_list            { font-size: ", floor($font_size * 0.9), "pt; }\n";
    echo ".recent_user_dropdown      { font-size: ", floor($font_size * 0.9), "pt; }\n";
    echo ".user_in_thread_dropdown   { font-size: ", floor($font_size * 0.9), "pt; }\n";
    echo ".highlight                 { font-size: ", $font_size, "pt; }\n";
    echo ".quotetext                 { font-size: ", floor($font_size * 0.9), "pt; }\n";
    echo ".spellcheckbodytext        { font-size: ", $font_size, "pt; }\n";
    echo ".activeusers               { font-size: ", floor($font_size * 0.9), "pt; }\n";
    echo ".adminipdisplay            { font-size: ", floor($font_size * 0.9), "pt; }\n";
    echo ".pmnewcount                { font-size: ", floor($font_size * 0.9), "pt; }\n";
    echo ".pmbar_text                { font-size: ", floor($font_size * 0.9), "pt; }\n";
    echo ".pagenum_text              { font-size: ", floor($font_size * 0.9), "pt; }\n";
    echo ".admin_settings_text       { font-size: ", floor($font_size * 0.9), "pt; }\n";
    echo ".navpage                   { font-size: ", $font_size * 0.9, "pt }\n";
    echo ".navpage                   { font-size: ", $font_size * 0.9, "pt }\n";
    echo ".subhead_sort_asc          { font-size: ", $font_size, "pt; }\n";
    echo ".subhead_sort_desc         { font-size: ", $font_size, "pt; }\n";
    echo ".error_msg                 { font-size: ", $font_size * 0.9, "pt }\n";
    echo ".success_msg               { font-size: ", $font_size * 0.9, "pt }\n";
    echo ".warning_msg               { font-size: ", $font_size * 0.9, "pt }\n";
}

?>