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

require_once("./include/db.inc.php");
require_once("./include/forum.inc.php");

function user_rel_update($uid,$peer_uid,$value){

    $db_user_rel_update = db_connect();

    $sql = "delete from ". forum_table("USER_PEER"). " where UID = $uid and PEER_UID = $peer_uid";
    db_query($sql, $db_user_rel_update);

    $sql = "insert into " . forum_table("USER_PEER") . " (UID, PEER_UID, RELATIONSHIP)";
    $sql .= " values ($uid, $peer_uid, $value)";

//      $sql = "update " . forum_table("USER_PREFS") . " set ";
//      $sql .= "VIEW_SIGS = $value where UID = $uid";

    $result = db_query($sql, $db_user_rel_update);

    return $result;
}

function user_rel_get($uid, $peer_uid){

    $db_user_rel_get = db_connect();

        $sql = "select RELATIONSHIP from " . forum_table("USER_PEER");
        $sql .= " where UID = '$uid' and PEER_UID = '$peer_uid'";

    $result = db_query($sql, $db_user_rel_get);

    if (!db_num_rows($result)) {
        return 0;
    } else {
        $fa = db_fetch_array($result);
        return $fa['RELATIONSHIP'];
    }
}

?>