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

/* $Id: user_profile.inc.php,v 1.25 2004-04-05 21:12:36 decoyduck Exp $ */

include_once("./include/profile.inc.php");

function user_profile_update($uid, $piid, $entry)
{
    $db_user_profile_update = db_connect();
    
    if (!$table_data = get_table_prefix()) return false;

    $entry = addslashes(_htmlentities($entry));

    $sql = "DELETE FROM {$table_data['PREFIX']}USER_PROFILE ";
    $sql.= "WHERE UID = $uid AND PIID = $piid";

    if (db_query($sql, $db_user_profile_update)) {

        $sql = "INSERT INTO {$table_data['PREFIX']}USER_PROFILE (UID, PIID, ENTRY) ";
        $sql.= "VALUES ($uid, $piid, '$entry')";

        return db_query($sql, $db_user_profile_update);
    }

    return false;
}

function user_get_profile_entries($uid, $psid)
{
    $db_user_get_profile_entries = db_connect();
    
    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT PI.NAME, PI.TYPE, UP.ENTRY FROM {$table_data['PREFIX']}PROFILE_ITEM PI ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PROFILE UP ON (UP.PIID = PI.PIID AND UP.UID = $uid) ";
    $sql.= "WHERE PI.PSID = $psid ORDER BY PI.POSITION, PI.PIID";

    $result = db_query($sql, $db_user_get_profile_entries);
    $user_profile_array = array();

    while ($row = db_fetch_array($result)) {
        $user_profile_array[] = $row;
    }

    return $user_profile_array;
}

function user_get_profile_image($uid)
{
    $db_user_get_profile_image = db_connect();
    
    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT PIC_URL from {$table_data['PREFIX']}USER_PREFS WHERE UID = $uid";
    $result = db_query($sql, $db_user_get_profile_image);

    $row = db_fetch_array($result);

    if (isset($row['PIC_URL']) && strlen($row['PIC_URL']) > 0) {
        return $row['PIC_URL'];
    }else {
        return false;
    }
}

?>