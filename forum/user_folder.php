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

/* $Id: user_folder.php,v 1.12 2004-03-10 18:43:18 decoyduck Exp $ */

//Multiple forum support
require_once("./include/forum.inc.php");

// Compress the output
require_once("./include/gzipenc.inc.php");

// Enable the error handler
require_once("./include/errorhandler.inc.php");

require_once("./include/session.inc.php");
require_once("./include/folder.inc.php");
require_once("./include/header.inc.php");

if (!bh_session_check()) {
    $uri = "./logon.php?webtag=$webtag&final_uri=". urlencode(get_request_uri());
    header_redirect($uri);
}

if (bh_session_get_value('UID') > 0) {
    if (isset($HTTP_GET_VARS['fid']) && is_numeric($HTTP_GET_VARS['fid']) && isset($HTTP_GET_VARS['interest']) && is_numeric($HTTP_GET_VARS['interest'])) {
        user_set_folder_interest($HTTP_GET_VARS['fid'], $HTTP_GET_VARS['interest']);
    }
}

header_redirect("./thread_list.php?webtag=$webtag");

?>