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

/* $Id: fontsize.php,v 1.38 2004-08-04 23:46:34 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

// Installation checking functions
include_once("./include/install.inc.php");

// Check that Beehive is installed correctly
check_install();

// Multiple forum support
include_once("./include/forum.inc.php");

// Fetch the forum settings
$forum_settings = get_forum_settings();

include_once("./include/header.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/logon.inc.php");
include_once("./include/session.inc.php");

if (!$user_sess = bh_session_check()) {

    html_draw_top();

    if (isset($_POST['user_logon']) && isset($_POST['user_password']) && isset($_POST['user_passhash'])) {

        if (perform_logon(false)) {

            $lang = load_language_file();
            $webtag = get_webtag($webtag_search);

            echo "<h1>{$lang['loggedinsuccessfully']}</h1>";
            echo "<div align=\"center\">\n";
            echo "<p><b>{$lang['presscontinuetoresend']}</b></p>\n";

            $request_uri = get_request_uri();

            echo "<form method=\"post\" action=\"$request_uri\" target=\"_self\">\n";
            echo form_input_hidden('webtag', $webtag);

            foreach($_POST as $key => $value) {
                echo form_input_hidden($key, _htmlentities(_stripslashes($value)));
            }

            echo form_submit(md5(uniqid(rand())), $lang['continue']), "&nbsp;";
            echo form_button(md5(uniqid(rand())), $lang['cancel'], "onclick=\"self.location.href='$request_uri'\""), "\n";
            echo "</form>\n";

            html_draw_bottom();
            exit;
        }
    }

    draw_logon_form(false);
    html_draw_bottom();
    exit;
}

// Load language file

$lang = load_language_file();

// Check we have a webtag

if (!$webtag = get_webtag($webtag_search)) {
    $request_uri = rawurlencode(get_request_uri(true));
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

// Check that we have access to this forum

if (!forum_check_access_level()) {
    $request_uri = rawurlencode(get_request_uri(true));
    header_redirect("./forums.php?webtag_search=$webtag_search&final_uri=$request_uri");
}

header("Content-Type: text/css");

$fontsize = bh_session_get_value('FONT_SIZE');

if ($fontsize <> 10) {

    $fontsize = bh_session_get_value('FONT_SIZE');

    if ($fontsize < 5) $fontsize = 5;
    if ($fontsize > 15) $fontsize = 15;

    echo "BODY               { font-size: ", $fontsize, "pt }\n";
    echo ".navpage           { font-size: ", $fontsize * 0.8, "pt }\n";
    echo "P                  { font-size: ", $fontsize, "pt }\n";
    echo "H1                 { font-size: ", $fontsize, "pt }\n";
    echo "H2                 { font-size: ", $fontsize, "pt }\n";
    echo ".smalltext         { font-size: ", floor($fontsize * 0.9), "pt }\n";
    echo ".thread_list_mode  { font-size: ", $fontsize, "pt }\n";
    echo ".threads           { font-size: ", $fontsize, "pt }\n";
    echo ".folderinfo        { font-size: ", floor($fontsize * 0.8), "pt }\n";
    echo ".folderpostnew     { font-size: ", floor($fontsize * 0.8), "pt }\n";
    echo ".threadname        { font-size: ", $fontsize, "pt }\n";
    echo ".threadtime        { font-size: ", floor($fontsize * 0.8), "pt }\n";
    echo ".threadxnewofy     { font-size: ", floor($fontsize * 0.8), "pt }\n";
    echo ".foldername        { font-size: ", $fontsize, "pt }\n";
    echo ".posthead          { font-size: ", $fontsize, "pt }\n";
    echo ".postbody          { font-size: ", $fontsize, "pt }\n";
    echo ".postnumber        { font-size: ", $fontsize, "pt }\n";
    echo ".postinfo          { font-size: ", $fontsize, "pt }\n";
    echo ".posttofromlabel   { font-size: ", $fontsize, "pt }\n";
    echo ".posttofrom        { font-size: ", $fontsize, "pt }\n";
    echo ".postresponse      { font-size: ", $fontsize, "pt }\n";
    echo ".messagefoot       { font-size: ", $fontsize, "pt }\n";
    echo ".notifier          { font-size: ", $fontsize, "pt }\n";
    echo ".button            { font-size: ", floor($fontsize * 0.9), "pt }\n";
    echo ".smallbutton       { font-size: ", floor($fontsize * 0.8), "pt }\n";
    echo ".subhead           { font-size: ", $fontsize, "pt }\n";
    echo ".bhinputtext       { font-size: ", floor($fontsize * 0.9), "pt }\n";
    echo ".bhtextarea        { font-size: ", floor($fontsize * 0.9), "pt }\n";
    echo ".bhselect          { font-size: ", floor($fontsize * 0.9), "pt }\n";
    echo ".bhinputcheckbox   { font-size: ", floor($fontsize * 0.8), "pt }\n";
    echo ".bhinputradio      { font-size: ", floor($fontsize * 0.8), "pt }\n";
    echo ".highlight         { font-size: ", $fontsize, "pt }\n";
    echo ".quotetext         { font-size: ", floor($fontsize * 0.8), "pt }\n";
    echo ".activeusers       { font-size: ", floor($fontsize * 0.8), "pt }\n";
    echo ".adminipdisplay    { font-size: ", floor($fontsize * 0.8), "pt }\n";
}

?>