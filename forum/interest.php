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

// Alter user's interest in a thread
// DOES NOT DISPLAY ANYTHING

// Enable the error handler
require_once("./include/errorhandler.inc.php");

// Compress the output
require_once("./include/gzipenc.inc.php");

require_once("./include/html.inc.php");
require_once("./include/db.inc.php");
require_once("./include/forum.inc.php");
require_once("./include/header.inc.php");

if ($HTTP_COOKIE_VARS['bh_sess_uid'] == 0) {
    html_guest_error();
    exit;
}

if (isset($HTTP_POST_VARS['tid']) && isset($HTTP_POST_VARS['interest'])) {

    $tid = $HTTP_POST_VARS['tid'];
    $int = $HTTP_POST_VARS['interest'];
    $uid = $HTTP_COOKIE_VARS['bh_sess_uid'];

    $db  = db_connect();
    $sql = "UPDATE LOW_PRIORITY ". forum_table("USER_THREAD"). " SET INTEREST = $int WHERE TID = $tid AND UID = $uid";

    db_query($sql,$db);
}

if (isset($HTTP_GET_VARS['ret'])) {
    header_redirect($HTTP_GET_VARS['ret']);
}else {
    header_redirect(basename($HTTP_SERVER_VARS['PHP_SELF']). "/messages.php");
}

?>