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

// Enable the error handler
require_once("./include/errorhandler.inc.php");

require_once("./include/db.inc.php");
require_once("./include/forum.inc.php");
require_once("./include/header.inc.php");
require_once("./include/admin.inc.php");

if(isset($HTTP_POST_VARS['move'])){
    if(isset($HTTP_POST_VARS['t_tid']) && isset($HTTP_POST_VARS['t_move'])){
        $tid = $HTTP_POST_VARS['t_tid'];
        $fid = $HTTP_POST_VARS['t_move'];

        $db = db_connect();
        $sql = "update ".forum_table("THREAD")." set FID = $fid where TID = $tid";

        db_query($sql,$db);

        admin_addlog(0, $fid, $tid, 0, 0, 0, 18);

    }
} else if(isset($HTTP_POST_VARS['close']) && isset($HTTP_POST_VARS['t_tid'])){
        $tid = $HTTP_POST_VARS['t_tid'];

        $db = db_connect();
        $sql = "update ".forum_table("THREAD")." set CLOSED = NOW() where TID = $tid";

        db_query($sql,$db);

        admin_addlog(0, 0, $tid, 0, 0, 0, 19);

} else if(isset($HTTP_POST_VARS['reopen']) && isset($HTTP_POST_VARS['t_tid'])){
        $tid = $HTTP_POST_VARS['t_tid'];

        $db = db_connect();
        $sql = "update ".forum_table("THREAD")." set CLOSED = NULL where TID = $tid";

        db_query($sql,$db);

        admin_addlog(0, 0, $tid, 0, 0, 0, 20);

} else if(isset($HTTP_POST_VARS['rename']) && isset($HTTP_POST_VARS['t_tid'])){
        $tid = $HTTP_POST_VARS['t_tid'];
        $name = mysql_escape_string(htmlspecialchars($HTTP_POST_VARS['t_name']));

        $db = db_connect();
        $sql = "update ".forum_table("THREAD")." set TITLE = \"$name\" where TID = $tid";

        db_query($sql,$db);

        admin_addlog(0, 0, $tid, 0, 0, 0, 21);

}

if(isset($HTTP_GET_VARS['ret'])){

    header_redirect($HTTP_GET_VARS['ret']);

} else {

    header_redirect(dirname($HTTP_SERVER_VARS['PHP_SELF']). "/messages.php");

}

?>