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

/* $Id: fontsize.php,v 1.20 2004-03-15 19:25:15 decoyduck Exp $ */

// Compress the output
include_once("./include/gzipenc.inc.php");

// Enable the error handler
include_once("./include/errorhandler.inc.php");

//Multiple forum support
include_once("./include/forum.inc.php");

include_once("./include/config.inc.php");
include_once("./include/header.inc.php");
include_once("./include/session.inc.php");

// Fetch the forum webtag

$webtag = get_webtag();

if (!$user_sess = bh_session_check()) {

    $uri = "./logon.php?webtag={$webtag['WEBTAG']}&final_uri=". rawurlencode(get_request_uri());
    header_redirect($uri);
}

// Load the wordfilter for the current user

$user_wordfilter = load_wordfilter();

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
    echo ".bhinputtext	     { font-size: ", floor($fontsize * 0.9), "pt }\n";
    echo ".bhtextarea	     { font-size: ", floor($fontsize * 0.9), "pt }\n";
    echo ".bhselect	     { font-size: ", floor($fontsize * 0.9), "pt }\n";
    echo ".bhinputcheckbox   { font-size: ", floor($fontsize * 0.8), "pt }\n";
    echo ".bhinputradio      { font-size: ", floor($fontsize * 0.8), "pt }\n";
    echo ".highlight         { font-size: ", $fontsize, "pt }\n";
    echo ".quotetext         { font-size: ", floor($fontsize * 0.8), "pt }\n";
    echo ".activeusers       { font-size: ", floor($fontsize * 0.8), "pt }\n";
    echo ".adminipdisplay    { font-size: ", floor($fontsize * 0.8), "pt }\n";
}

?>