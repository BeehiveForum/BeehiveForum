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

/* $Id: fontsize.php,v 1.5 2003-07-27 12:42:03 hodcroftcj Exp $ */

// Enable the error handler
require_once("./include/errorhandler.inc.php");

// style.php : handles site styles with user preferences

// Compress the output
require_once("./include/gzipenc.inc.php");

require_once("./include/header.inc.php");
require_once("./include/config.inc.php");
require_once("./include/session.inc.php");

header("Content-Type: text/css");

if (bh_session_get_value('FONT_SIZE') != '10') {

    $fontsize = bh_session_get_value('FONT_SIZE');

    echo "BODY               { font-size: ", $fontsize, "pt }\n";
    echo "P                  { font-size: ", $fontsize, "pt }\n";
    echo "H1                 { font-size: ", $fontsize, "pt }\n";
    echo "H2                 { font-size: ", $fontsize, "pt }\n";
    echo ".thread_list_mode  { font-size: ", $fontsize, "pt }\n";
    echo ".threads           { font-size: ", $fontsize, "pt }\n";
    echo ".threadname        { font-size: ", $fontsize, "pt }\n";
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
    echo ".subhead           { font-size: ", $fontsize, "pt }\n";

}

?>