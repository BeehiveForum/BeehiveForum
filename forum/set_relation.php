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

/* $Id: set_relation.php,v 1.21 2003-09-15 19:04:30 decoyduck Exp $ */

// Enable the error handler
require_once("./include/errorhandler.inc.php");

// Compress the output
require_once("./include/gzipenc.inc.php");

// Alter user's interest in a thread
// DOES NOT DISPLAY ANYTHING

require_once("./include/html.inc.php");
require_once("./include/user_rel.inc.php");
require_once("./include/constants.inc.php");
require_once("./include/session.inc.php");

if (!bh_session_check()) {

    if (isset($HTTP_GET_VARS['msg'])) {
      $uri = "./index.php?msg=". $HTTP_GET_VARS['msg'];
    }else {
      $uri = "./index.php?final_uri=". urlencode(get_request_uri());
    }

    header_redirect($uri);

}

if (bh_session_get_value('UID') == 0) {
    html_guest_error();
    exit;
}

require_once("./include/db.inc.php");
require_once("./include/header.inc.php");
require_once("./include/forum.inc.php");

if(isset($HTTP_GET_VARS['uid']) && isset($HTTP_GET_VARS['rel']) && is_numeric($HTTP_GET_VARS['uid']) && is_numeric($HTTP_GET_VARS['rel'])) {

    $uid  = bh_session_get_value('UID');
    $puid = $HTTP_GET_VARS['uid'];
    $rel  = $HTTP_GET_VARS['rel'];

    $relationship = user_rel_get($uid, $puid);

    if ($rel == -1) {
        $relationship = ($relationship & USER_IGNORED_SIG) ? USER_IGNORED_SIG + USER_IGNORED : USER_IGNORED;
    }else {
        $relationship = ($relationship & USER_IGNORED_SIG) ? USER_IGNORED_SIG : 0;
    }

    user_rel_update($uid, $puid, $relationship);

}else {

    html_draw_top();
    echo "<h1>Invalid Operation</h1>\n";
    echo "<h2>required information not found</h2>";
    // -- html_draw_bottom is now handled by bh_gz_handler -- html_draw_bottom();
    exit;

}

if (isset($HTTP_GET_VARS['msg'])) {
    $msg = $HTTP_GET_VARS['msg'];
    header_redirect("./messages.php?msg=$msg");
}else {
    header_redirect("./messages.php");
}

?>