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

/* $Id: user_rel.inc.php,v 1.24 2005-04-01 13:17:12 rowan_hill Exp $ */

/**
* User relation functions
*/

/**
*/
include_once(BH_INCLUDE_PATH. "forum.inc.php");

function user_rel_update($uid, $peer_uid, $value)
{
    $db_user_rel_update = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT UID FROM {$table_data['PREFIX']}USER_PEER ";
    $sql.= "WHERE UID = '$uid' AND PEER_UID = '$peer_uid'";

    $result = db_query($sql, $db_user_rel_update);

    if (db_num_rows($result) > 0) {

        $sql = "UPDATE {$table_data['PREFIX']}USER_PEER SET RELATIONSHIP = '$value' ";
        $sql.= "WHERE UID = '$uid' AND PEER_UID = '$peer_uid'";

    }else {

        $sql = "INSERT INTO {$table_data['PREFIX']}USER_PEER (UID, PEER_UID, RELATIONSHIP) ";
        $sql.= "VALUES ('$uid', '$peer_uid', '$value')";
    }

    return db_query($sql, $db_user_rel_update);
}


/**
* Gets relationship between two users
* 
* Gets relationships set by $uid of $peer_uid. For example, 
* if someone of UID 2 has set the admin (UID 1) as a friend 
* (not the other way round), calling user_rel_get(2, 1) 
* will return USER_FRIEND. Note: This has no bearing on
* what user_rel_get(1, 2) will return.
*
* @return integer
* @param integer $uid UID of user who set the relations
* @param integer $peer_uid UID of user who is being related to
* @see constants.inc.php
*/
function user_rel_get($uid, $peer_uid)
{
    $db_user_rel_get = db_connect();

    if (!$table_data = get_table_prefix()) return 0;

    $sql = "SELECT RELATIONSHIP FROM {$table_data['PREFIX']}USER_PEER ";
    $sql.= "WHERE UID = '$uid' AND PEER_UID = '$peer_uid'";

    $result = db_query($sql, $db_user_rel_get);

    if (db_num_rows($result) > 0) {

        list($relationship) = db_fetch_array($result, DB_RESULT_NUM);
        return $relationship;
    }

    return 0;
}

?>