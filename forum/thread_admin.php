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

require_once("./include/db.inc.php");
require_once("./include/forum.inc.php");

if(isset($HTTP_POST_VARS['move'])){
    if(isset($HTTP_POST_VARS['t_tid']) && isset($HTTP_POST_VARS['t_move'])){
        $tid = $HTTP_POST_VARS['t_tid'];
        $fid = $HTTP_POST_VARS['t_move'];

        $db = db_connect();
        $sql = "update ".forum_table("THREAD")." set FID = $fid where TID = $tid";

        db_query($sql,$db);

        db_disconnect($db);
    }
} else if(isset($HTTP_POST_VARS['close']) && isset($HTTP_POST_VARS['t_tid'])){
        $tid = $HTTP_POST_VARS['t_tid'];

        $db = db_connect();
        $sql = "update ".forum_table("THREAD")." set CLOSED = NOW() where TID = $tid";

        db_query($sql,$db);

        db_disconnect($db);
}

if(isset($HTTP_GET_VARS['ret'])){
    header("Location: http://".$HTTP_SERVER_VARS['HTTP_HOST'].$ret);
} else {
    header("Location: http://".$HTTP_SERVER_VARS['HTTP_HOST'].dirname($HTTP_SERVER_VARS['PHP_SELF'])."/messages.php");
}

?>
