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

/* $Id: user_profile.inc.php,v 1.34 2004-11-13 19:00:54 decoyduck Exp $ */

include_once("./include/forum.inc.php");
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

function user_get_profile($uid)
{
    $db_user_get_profile = db_connect();

    if (!is_numeric($uid)) return false;

    // UID of the user viewing the profile data

    $peer_uid = bh_session_get_value('UID');

    if (!$table_data = get_table_prefix()) return false;

    $user_prefs = user_get_prefs($uid);

    $sql = "SELECT USER.LOGON, USER.NICKNAME, USER_PEER.RELATIONSHIP, ";
    $sql.= "UNIX_TIMESTAMP(VISITOR_LOG.LAST_LOGON) AS LAST_LOGON, ";
    $sql.= "COUNT(POST.FROM_UID) AS POST_COUNT FROM USER USER ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER ";
    $sql.= "ON (USER_PEER.PEER_UID = USER.UID AND USER_PEER.UID = '$peer_uid') ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}VISITOR_LOG VISITOR_LOG ";
    $sql.= "ON (VISITOR_LOG.UID = USER.UID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}POST POST ";
    $sql.= "ON (POST.FROM_UID = USER.UID) ";
    $sql.= "WHERE USER.UID = '$uid' ";
    $sql.= "GROUP BY USER.UID";

    $result = db_query($sql, $db_user_get_profile);

    if (db_num_rows($result) > 0) {

        $user_profile = db_fetch_array($result);

        if (isset($user_prefs['ANON_LOGON']) && $user_prefs['ANON_LOGON'] == "Y") {
            $user_profile['LAST_LOGON'] = "Unknown";
        }else {
            $user_profile['LAST_LOGON'] = format_time($user_profile['LAST_LOGON']);
        }

        if (isset($user_prefs['DOB_DISPLAY']) && $user_prefs['DOB_DISPLAY'] == 2 && !empty($user_prefs['DOB']) && $user_prefs['DOB'] != "0000-00-00") {
            $user_profile['DOB'] = format_birthday($user_prefs['DOB']);
        }

        if (isset($user_prefs['DOB_DISPLAY']) && $user_prefs['DOB_DISPLAY'] > 0 && !empty($user_prefs['DOB']) && $user_prefs['DOB'] != "0000-00-00") {
            $user_profile['AGE'] = format_age($user_prefs['DOB']);
        }

        if (isset($user_prefs['PIC_URL']) && strlen($user_prefs['PIC_URL']) > 0) {
            $user_profile['PIC_URL'] = $user_prefs['PIC_URL'];
        }

        if (!isset($user_profile['RELATIONSHIP'])) {
            $user_profile['RELATIONSHIP'] = 0;
        }

        return $user_profile;
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