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

// style.php : handles site styles with user preferences

// Compress the output
require_once("./include/gzipenc.inc.php");

require_once("./include/header.inc.php");
require_once("./include/config.inc.php");

header("Content-Type: text/css");

if ($HTTP_COOKIE_VARS['bh_sess_fontsize'] != '10') {

    echo "BODY               { font-size: ", $HTTP_COOKIE_VARS['bh_sess_fontsize'], "pt }\n";
    echo "P                  { font-size: ", $HTTP_COOKIE_VARS['bh_sess_fontsize'], "pt }\n";
    echo "H1                 { font-size: ", $HTTP_COOKIE_VARS['bh_sess_fontsize'], "pt }\n";
    echo "H2                 { font-size: ", $HTTP_COOKIE_VARS['bh_sess_fontsize'], "pt }\n";
    echo ".thread_list_mode  { font-size: ", $HTTP_COOKIE_VARS['bh_sess_fontsize'], "pt }\n";
    echo ".threads           { font-size: ", $HTTP_COOKIE_VARS['bh_sess_fontsize'], "pt }\n";
    echo ".threadname        { font-size: ", $HTTP_COOKIE_VARS['bh_sess_fontsize'], "pt }\n";
    echo ".foldername        { font-size: ", $HTTP_COOKIE_VARS['bh_sess_fontsize'], "pt }\n";
    echo ".posthead          { font-size: ", $HTTP_COOKIE_VARS['bh_sess_fontsize'], "pt }\n";
    echo ".postbody          { font-size: ", $HTTP_COOKIE_VARS['bh_sess_fontsize'], "pt }\n";
    echo ".postnumber        { font-size: ", $HTTP_COOKIE_VARS['bh_sess_fontsize'], "pt }\n";
    echo ".postinfo          { font-size: ", $HTTP_COOKIE_VARS['bh_sess_fontsize'], "pt }\n";
    echo ".posttofromlabel   { font-size: ", $HTTP_COOKIE_VARS['bh_sess_fontsize'], "pt }\n";
    echo ".posttofrom        { font-size: ", $HTTP_COOKIE_VARS['bh_sess_fontsize'], "pt }\n";
    echo ".postresponse      { font-size: ", $HTTP_COOKIE_VARS['bh_sess_fontsize'], "pt }\n";
    echo ".messagefoot       { font-size: ", $HTTP_COOKIE_VARS['bh_sess_fontsize'], "pt }\n";
    echo ".notifier          { font-size: ", $HTTP_COOKIE_VARS['bh_sess_fontsize'], "pt }\n";
    echo ".subhead           { font-size: ", $HTTP_COOKIE_VARS['bh_sess_fontsize'], "pt }\n";

}

?>