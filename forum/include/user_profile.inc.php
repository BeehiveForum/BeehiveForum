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

/* $Id: user_profile.inc.php,v 1.59 2007-04-21 18:14:56 decoyduck Exp $ */

/**
* Functions relating to users interacting with profiles
*/

/**
*/

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "profile.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

function user_profile_update($uid, $piid, $entry, $privacy)
{
    $db_user_profile_update = db_connect();

    if (!is_numeric($uid)) return false;
    if (!is_numeric($piid)) return false;
    if (!is_numeric($privacy)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $entry = addslashes(_htmlentities($entry));

    $sql = "DELETE FROM {$table_data['PREFIX']}USER_PROFILE ";
    $sql.= "WHERE UID = '$uid' AND PIID = '$piid'";

    if (db_query($sql, $db_user_profile_update)) {

        $sql = "INSERT INTO {$table_data['PREFIX']}USER_PROFILE (UID, PIID, ENTRY, PRIVACY) ";
        $sql.= "VALUES ($uid, $piid, '$entry', $privacy)";

        return db_query($sql, $db_user_profile_update);
    }

    return false;
}

function user_get_profile($uid)
{
    $lang = load_language_file();
    
    $db_user_get_profile = db_connect();

    if (!is_numeric($uid)) return false;

    // UID of the user viewing the profile data

    $peer_uid = bh_session_get_value('UID');

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    $user_prefs = user_get_prefs($uid);

    $sql = "SELECT USER.LOGON, USER.NICKNAME, USER_PEER.PEER_NICKNAME, ";
    $sql.= "UNIX_TIMESTAMP(USER_FORUM.LAST_VISIT) AS LAST_VISIT, ";
    $sql.= "UNIX_TIMESTAMP(USER.REGISTERED) AS REGISTERED, ";
    $sql.= "USER_PREFS_FORUM.ANON_LOGON AS FORUM_ANON_LOGON, ";
    $sql.= "USER_PREFS_GLOBAL.ANON_LOGON AS GLOBAL_ANON_LOGON, ";
    $sql.= "UNIX_TIMESTAMP(USER_TRACK.USER_TIME_BEST) AS USER_TIME_BEST, ";
    $sql.= "UNIX_TIMESTAMP(USER_TRACK.USER_TIME_TOTAL) AS USER_TIME_TOTAL, ";
    $sql.= "USER_PEER.RELATIONSHIP FROM USER USER ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PREFS USER_PREFS_FORUM ";
    $sql.= "ON (USER_PREFS_FORUM.UID = USER.UID) ";
    $sql.= "LEFT JOIN USER_PREFS USER_PREFS_GLOBAL ";
    $sql.= "ON (USER_PREFS_GLOBAL.UID = USER.UID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER ";
    $sql.= "ON (USER_PEER.PEER_UID = USER.UID AND USER_PEER.UID = '$peer_uid') ";
    $sql.= "LEFT JOIN USER_FORUM USER_FORUM ON (USER_FORUM.UID = USER.UID ";
    $sql.= "AND USER_FORUM.FID = '$forum_fid') ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_TRACK USER_TRACK ";
    $sql.= "ON (USER_TRACK.UID = USER.UID) ";
    $sql.= "WHERE USER.UID = '$uid' ";
    $sql.= "GROUP BY USER.UID";

    $result = db_query($sql, $db_user_get_profile);

    if (db_num_rows($result) > 0) {

        $user_profile = db_fetch_array($result);

        if (isset($user_profile['FORUM_ANON_LOGON']) && $user_profile['FORUM_ANON_LOGON'] > 0) {
            $anon_logon = $user_profile['FORUM_ANON_LOGON'];
        }elseif (isset($user_profile['GLOBAL_ANON_LOGON']) && $user_profile['GLOBAL_ANON_LOGON'] > 0) {
            $anon_logon = $user_profile['GLOBAL_ANON_LOGON'];
        }else {
            $anon_logon = 0;
        }

        if ($anon_logon == 0 && isset($user_profile['LAST_VISIT']) && $user_profile['LAST_VISIT'] > 0) {
            $user_profile['LAST_LOGON'] = format_time($user_profile['LAST_VISIT']);
        }else {
            $user_profile['LAST_LOGON'] = $lang['unknown'];
        }

        if (isset($user_profile['REGISTERED']) && $user_profile['REGISTERED'] > 0) {
            $user_profile['REGISTERED'] = format_date($user_profile['REGISTERED']);
        }else {
            $user_profile['REGISTERED'] = $lang['unknown'];
        }

        if (isset($user_profile['USER_TIME_BEST']) && $user_profile['USER_TIME_BEST'] > 0) {
            $user_profile['USER_TIME_BEST'] = format_time_display($user_profile['USER_TIME_BEST']);
        }else {
            $user_profile['USER_TIME_BEST'] = $lang['unknown'];
        }

        if (isset($user_profile['USER_TIME_TOTAL']) && $user_profile['USER_TIME_TOTAL'] > 0) {
            $user_profile['USER_TIME_TOTAL'] = format_time_display($user_profile['USER_TIME_TOTAL']);
        }else {
            $user_profile['USER_TIME_TOTAL'] = $lang['unknown'];
        }

        if (isset($user_prefs['DOB_DISPLAY']) && $user_prefs['DOB_DISPLAY'] == 2 && !empty($user_prefs['DOB']) && $user_prefs['DOB'] != "0000-00-00") {
            $user_profile['DOB'] = format_birthday($user_prefs['DOB']);
        }

        if (isset($user_prefs['DOB_DISPLAY']) && $user_prefs['DOB_DISPLAY'] == 3 && !empty($user_prefs['DOB']) && $user_prefs['DOB'] != "0000-00-00") {
            $user_profile['DOB'] = format_birthday($user_prefs['DOB']);
        }

        if (isset($user_prefs['DOB_DISPLAY']) && $user_prefs['DOB_DISPLAY'] > 0 && $user_prefs['DOB_DISPLAY'] < 3 && !empty($user_prefs['DOB']) && $user_prefs['DOB'] != "0000-00-00") {
            $user_profile['AGE'] = format_age($user_prefs['DOB']);
        }

        if (isset($user_prefs['PIC_URL']) && strlen($user_prefs['PIC_URL']) > 0) {
            $user_profile['PIC_URL'] = $user_prefs['PIC_URL'];
        }

        if (isset($user_prefs['HOMEPAGE_URL']) && strlen($user_prefs['HOMEPAGE_URL']) > 0) {
            $user_profile['HOMEPAGE_URL'] = $user_prefs['HOMEPAGE_URL'];
        }

        if (!isset($user_profile['RELATIONSHIP'])) {
            $user_profile['RELATIONSHIP'] = 0;
        }

        if (isset($user_profile['PEER_NICKNAME'])) {
            if (!is_null($user_profile['PEER_NICKNAME']) && strlen($user_profile['PEER_NICKNAME']) > 0) {
                $user_profile['NICKNAME'] = $user_profile['PEER_NICKNAME'];
            }
        }

        $user_profile['POST_COUNT'] = user_get_post_count($uid);

        return $user_profile;
    }

    return false;
}

function user_get_profile_entries($uid, $psid)
{
    $db_user_get_profile_entries = db_connect();

    if (!is_numeric($uid)) return false;
    if (!is_numeric($psid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT PI.NAME, PI.TYPE, UP.ENTRY, UP.PRIVACY FROM {$table_data['PREFIX']}PROFILE_ITEM PI ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PROFILE UP ON (UP.PIID = PI.PIID AND UP.UID = '$uid') ";
    $sql.= "WHERE PI.PSID = '$psid' ORDER BY PI.POSITION, PI.PIID";

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

    if (!is_numeric($uid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT PIC_URL from {$table_data['PREFIX']}USER_PREFS WHERE UID = '$uid'";
    $result = db_query($sql, $db_user_get_profile_image);

    $row = db_fetch_array($result);

    if (isset($row['PIC_URL']) && strlen($row['PIC_URL']) > 0) {
        return $row['PIC_URL'];
    }

    return false;
}

function user_get_post_count($uid)
{
    if (!is_numeric($uid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $db_user_get_post_count = db_connect();

    $sql = "SELECT POST_COUNT FROM {$table_data['PREFIX']}USER_TRACK ";
    $sql.= "WHERE UID = '$uid'";

    $result = db_query($sql, $db_user_get_post_count);

    if (db_num_rows($result) > 0) {

        $post_count = db_fetch_array($result);

        if (isset($post_count['POST_COUNT']) && !is_null($post_count['POST_COUNT'])) {

            return $post_count['POST_COUNT'];
        }
    }

    $sql = "SELECT COUNT(PID) AS COUNT FROM {$table_data['PREFIX']}POST ";
    $sql.= "WHERE FROM_UID = '$uid'";

    $result = db_query($sql, $db_user_get_post_count);
    list($post_count) = db_fetch_array($result, DB_RESULT_NUM);

    $sql = "UPDATE {$table_data['PREFIX']}USER_TRACK ";
    $sql.= "SET POST_COUNT = '$post_count' WHERE UID = '$uid'";

    $result = db_query($sql, $db_user_get_post_count);

    if (db_affected_rows($db_user_get_post_count) < 1) {

        $sql = "INSERT IGNORE INTO {$table_data['PREFIX']}USER_TRACK ";
        $sql.= "(UID, POST_COUNT) VALUES ($uid, $post_count)";

        $result = db_query($sql, $db_user_get_post_count);
    }

    return $post_count;
}

function user_profile_popup_callback($logon)
{
    $webtag = get_webtag($webtag_search);
    
    $html = "<a href=\"user_profile.php?webtag=$webtag&amp;logon=$logon\" target=\"_blank\" ";
    $html.= "onclick=\"return openProfileByLogon('$logon', '$webtag')\">$logon</a>";

    return $html;
}

?>