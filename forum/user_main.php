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

/* $Id: user_main.php,v 1.3 2004-03-10 18:43:18 decoyduck Exp $ */

//Multiple forum support
require_once("./include/forum.inc.php");

// Frameset for thread list and messages

// Compress the output
require_once("./include/gzipenc.inc.php");

// Enable the error handler
require_once("./include/errorhandler.inc.php");

//Check logged in status
require_once("./include/session.inc.php");
require_once("./include/header.inc.php");

if(!bh_session_check()){

    $uri = "./logon.php?webtag=$webtag&final_uri=". urlencode(get_request_uri());
    header_redirect($uri);

}

require_once("./include/perm.inc.php");
require_once("./include/html.inc.php");
require_once("./include/constants.inc.php");
require_once("./include/lang.inc.php");

html_draw_top();

echo "<h1>{$lang['mycontrols']}</h1>\n";
echo "<p>{$lang['userexp_1']}</p>\n";
echo "<p>{$lang['userexp_2']}</p>\n";
echo "<p>{$lang['userexp_3']}</p>\n";
echo "<p>{$lang['userexp_4']}</p>\n";
echo "<p>{$lang['userexp_5']}</p>\n";
echo "<p>{$lang['userexp_6']}</p>\n";
echo "<p>{$lang['userexp_7']}</p>\n";
echo "<p>{$lang['userexp_8']}</p>\n";

html_draw_bottom();

?>