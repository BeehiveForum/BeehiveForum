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

/* $Id: user_profile.inc.php,v 1.41 2005-04-01 13:17:12 rowan_hill Exp $ */

/**
* Functions relating to users interacting with profiles
*/

/**
*/

include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "profile.inc.php");

function user_profile_update($uid, $piid, $entry, $privacy)
{
    $db_user_profile_update = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    $entry = addslashes(_htmlentities($entry));

    $sql = "DELETE FROM {$table_data['PREFIX']}USER_PROFILE ";
    $sql.= "WHERE UID = $uid AND PIID = $piid";

    if (db_query($sql, $db_user_profile_update)) {

        $sql = "INSERT INTO {$table_data['PREFIX']}USER_PROFILE (UID, PIID, ENTRY, PRIVACY) ";
        $sql.= "VALUES ($uid, $piid, '$entry', $privacy)";

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
    $sql.= "UNIX_TIMESTAMP(VISITOR_LOG.LAST_LOGON) AS LAST_LOGON FROM USER USER ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER ";
    $sql.= "ON (USER_PEER.PEER_UID = USER.UID AND USER_PEER.UID = '$peer_uid') ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}VISITOR_LOG VISITOR_LOG ";
    $sql.= "ON (VISITOR_LOG.UID = USER.UID) ";
    $sql.= "WHERE USER.UID = '$uid' ";
    $sql.= "GROUP BY USER.UID";

    $result = db_query($sql, $db_user_get_profile);

    if (db_num_rows($result) > 0) {

        $user_profile = db_fetch_array($result);

        if (isset($user_profile['LAST_LOGON']) && $user_profile['LAST_LOGON'] > 0) {
            $user_profile['LAST_LOGON'] = format_time($user_profile['LAST_LOGON']);
        }else {
            $user_profile['LAST_LOGON'] = "Unknown";
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

        $user_profile['POST_COUNT'] = user_get_post_count($uid);

        return $user_profile;
    }

    return false;
}

function user_get_profile_entries($uid, $psid)
{
    $db_user_get_profile_entries = db_connect();

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT PI.NAME, PI.TYPE, UP.ENTRY, UP.PRIVACY FROM {$table_data['PREFIX']}PROFILE_ITEM PI ";
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

function user_get_post_count($uid)
{
    if (!is_numeric($uid)) return 0;

    if (!$table_data = get_table_prefix()) return 0;

    $db_user_get_count = db_connect();

    $sql = "SELECT COUNT(PID) AS COUNT FROM ";
    $sql.= "{$table_data['PREFIX']}POST ";
    $sql.= "WHERE FROM_UID = $uid";

    $result = db_query($sql, $db_user_get_count);

    $post_count = db_fetch_array($result);

    return $post_count['COUNT'];
}

?>