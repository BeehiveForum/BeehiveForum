<?php

/*======================================================================
Copyright Project BeehiveForum 2002

This file is part of BeehiveForum.

BeehiveForum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

BeehiveForum is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Beehive; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307
USA
======================================================================*/

/* $Id: font_size.php,v 1.15 2007-05-21 00:14:21 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "./include/");

// Server checking functions
include_once(BH_INCLUDE_PATH. "server.inc.php");

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

// Fetch the forum settings
$forum_settings = forum_get_settings();

include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");

// Check we're logged in correctly

if (!$user_sess = bh_session_check()) {
    $request_uri = rawurlencode(get_request_uri());
    $webtag = get_webtag($webtag_search);
    header_redirect("./logon.php?webtag=$webtag&final_uri=$request_uri");
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

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri(false));
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Load language file

$lang = load_language_file();

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri());
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

header("Content-Type: text/css");

$fontsize = bh_session_get_value('FONT_SIZE');

if ($fontsize <> 10) {

    if ($fontsize < 5) $fontsize = 5;
    if ($fontsize > 15) $fontsize = 15;

    echo "body                       { font-size: ", $fontsize, "pt; }\n";
    echo ".navpage                   { font-size: ", $fontsize * 0.9, "pt }\n";
    echo "p                          { font-size: ", $fontsize, "pt; }\n";
    echo "h1                         { font-size: ", $fontsize, "pt; }\n";
    echo "h2                         { font-size: ", $fontsize, "pt; }\n";
    echo ".smalltext                 { font-size: ", floor($fontsize * 0.9), "pt; }\n";
    echo ".thread_list_mode          { font-size: ", $fontsize, "pt; }\n";
    echo ".threads                   { font-size: ", $fontsize, "pt; }\n";
    echo ".threads_left              { font-size: ", $fontsize, "pt; }\n";
    echo ".threads_right             { font-size: ", $fontsize, "pt; }\n";
    echo ".threads_top_left          { font-size: ", $fontsize, "pt; }\n";
    echo ".threads_top_right         { font-size: ", $fontsize, "pt; }\n";
    echo ".threads_bottom_left       { font-size: ", $fontsize, "pt; }\n";
    echo ".threads_bottom_right      { font-size: ", $fontsize, "pt; }\n";
    echo ".threads_left_right        { font-size: ", $fontsize, "pt; }\n";
    echo ".threads_left_right_bottom { font-size: ", $fontsize, "pt; }\n";
    echo ".threads_top_left_bottom   { font-size: ", $fontsize, "pt; }\n";
    echo ".threads_top_right_bottom  { font-size: ", $fontsize, "pt; }\n";
    echo ".folderinfo                { font-size: ", floor($fontsize * 0.9), "pt; }\n";
    echo ".folderpostnew             { font-size: ", floor($fontsize * 0.9), "pt; }\n";
    echo ".threadname                { font-size: ", $fontsize, "pt; }\n";
    echo ".threadtime                { font-size: ", floor($fontsize * 0.9), "pt; }\n";
    echo ".threadxnewofy             { font-size: ", floor($fontsize * 0.9), "pt; }\n";
    echo ".foldername                { font-size: ", $fontsize, "pt; }\n";
    echo ".posthead                  { font-size: ", $fontsize, "pt; }\n";
    echo ".pmheadl                   { font-size: ", $fontsize, "pt; }\n";
    echo ".pmheadr                   { font-size: ", $fontsize, "pt; }\n";
    echo ".postbody                  { font-size: ", $fontsize, "pt; }\n";
    echo ".postinfo                  { font-size: ", $fontsize, "pt; }\n";
    echo ".posttofromlabel           { font-size: ", $fontsize, "pt; }\n";
    echo ".posttofrom                { font-size: ", $fontsize, "pt; }\n";
    echo ".postresponse              { font-size: ", $fontsize, "pt; }\n";
    echo ".messagefoot               { font-size: ", $fontsize, "pt; }\n";
    echo ".dictionary_button         { font-size: ", floor($fontsize * 0.9), "pt; }\n";
    echo ".button                    { font-size: ", floor($fontsize * 0.9), "pt; }\n";
    echo ".button_disabled           { font-size: ", floor($fontsize * 0.9), "pt; }\n";
    echo ".smallbutton               { font-size: ", floor($fontsize * 0.9), "pt; }\n";
    echo ".subhead                   { font-size: ", $fontsize, "pt; }\n";
    echo ".bhinputtext               { font-size: ", floor($fontsize * 1.2), "pt; }\n";
    echo ".bhtextarea                { font-size: ", floor($fontsize * 1.2), "pt; }\n";
    echo ".bhselect                  { font-size: ", floor($fontsize * 0.9), "pt; }\n";
    echo ".bhinputcheckbox           { font-size: ", floor($fontsize * 0.9), "pt; }\n";
    echo ".bhinputradio              { font-size: ", floor($fontsize * 0.9), "pt; }\n";
    echo ".install_dropdown          { font-size: ", floor($fontsize * 0.9), "pt; }\n";
    echo ".logon_dropdown            { font-size: ", floor($fontsize * 0.9), "pt; }\n";
    echo ".register_dropdown         { font-size: ", floor($fontsize * 0.9), "pt; }\n";
    echo ".search_dropdown           { font-size: ", floor($fontsize * 0.9), "pt; }\n";
    echo ".banned_dropdown           { font-size: ", floor($fontsize * 0.9), "pt; }\n";
    echo ".links_dropdown            { font-size: ", floor($fontsize * 0.9), "pt; }\n";
    echo ".admin_startpage_textarea  { font-size: ", floor($fontsize * 0.9), "pt; }\n";
    echo ".dictionary_word_display   { font-size: ", floor($fontsize * 0.9), "pt; }\n";
    echo ".dictionary_best_selection { font-size: ", floor($fontsize * 0.9), "pt; }\n";
    echo ".dictionary_change_to      { font-size: ", floor($fontsize * 0.9), "pt; }\n";
    echo ".post_folder_dropdown      { font-size: ", floor($fontsize * 0.9), "pt; }\n";
    echo ".thread_title              { font-size: ", floor($fontsize * 0.9), "pt; }\n";
    echo ".post_to_others            { font-size: ", floor($fontsize * 0.9), "pt; }\n";
    echo ".post_content              { font-size: ", floor($fontsize * 0.9), "pt; }\n";
    echo ".signature_content         { font-size: ", floor($fontsize * 0.9), "pt; }\n";
    echo ".to_uid_dropdown           { font-size: ", floor($fontsize * 0.9), "pt; }\n";
    echo ".recipient_dropdown        { font-size: ", floor($fontsize * 0.9), "pt; }\n";
    echo ".recipient_list            { font-size: ", floor($fontsize * 0.9), "pt; }\n";
    echo ".recent_user_dropdown      { font-size: ", floor($fontsize * 0.9), "pt; }\n";
    echo ".user_in_thread_dropdown   { font-size: ", floor($fontsize * 0.9), "pt; }\n";
    echo ".highlight                 { font-size: ", $fontsize, "pt; }\n";
    echo ".quotetext                 { font-size: ", floor($fontsize * 0.9), "pt; }\n";
    echo ".spellcheckbodytext        { font-size: ", $fontsize, "pt; }\n";
    echo ".activeusers               { font-size: ", floor($fontsize * 0.9), "pt; }\n";
    echo ".adminipdisplay            { font-size: ", floor($fontsize * 0.9), "pt; }\n";
    echo ".pmnewcount                { font-size: ", floor($fontsize * 0.9), "pt; }\n";
    echo ".pmbar_text                { font-size: ", floor($fontsize * 0.9), "pt; }\n";
    echo ".pagenum_text              { font-size: ", floor($fontsize * 0.9), "pt; }\n";
    echo ".admin_settings_text       { font-size: ", floor($fontsize * 0.9), "pt; }\n";
    echo ".navpage                   { font-size: ", $fontsize * 0.9, "pt }\n";
    echo ".navpage                   { font-size: ", $fontsize * 0.9, "pt }\n";
    echo ".text_captcha_error        { font-size: ", floor($fontsize * 0.9), "pt; }\n";
    echo ".subhead_sort_asc          { font-size: ", $fontsize, "pt; }\n";
    echo ".subhead_sort_desc         { font-size: ", $fontsize, "pt; }\n";
}

?>