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

/* $Id: user_profile.inc.php,v 1.74 2007-08-26 11:30:32 decoyduck Exp $ */

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

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "profile.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "timezone.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");
include_once(BH_INCLUDE_PATH. "user_rel.inc.php");

function user_profile_update($uid, $piid, $entry, $privacy)
{
    $db_user_profile_update = db_connect();

    if (!is_numeric($uid)) return false;
    if (!is_numeric($piid)) return false;
    if (!is_numeric($privacy)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $entry = db_escape_string(_htmlentities($entry));

    $sql = "DELETE FROM {$table_data['PREFIX']}USER_PROFILE ";
    $sql.= "WHERE UID = '$uid' AND PIID = '$piid'";

    if ($result = db_query($sql, $db_user_profile_update)) {

        $sql = "INSERT INTO {$table_data['PREFIX']}USER_PROFILE (UID, PIID, ENTRY, PRIVACY) ";
        $sql.= "VALUES ($uid, $piid, '$entry', $privacy)";

        if (!$result = db_query($sql, $db_user_profile_update)) return false;
    }

    return true;
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

    $session_stamp = time() - intval(forum_get_setting('active_sess_cutoff', false, 900));

    $sql = "SELECT USER.LOGON, USER.NICKNAME, USER_PEER.PEER_NICKNAME, ";
    $sql.= "UNIX_TIMESTAMP(USER_FORUM.LAST_VISIT) AS LAST_VISIT, ";
    $sql.= "UNIX_TIMESTAMP(USER.REGISTERED) AS REGISTERED, ";
    $sql.= "USER_PREFS_FORUM.ANON_LOGON AS FORUM_ANON_LOGON, ";
    $sql.= "USER_PREFS_GLOBAL.ANON_LOGON AS GLOBAL_ANON_LOGON, ";
    $sql.= "UNIX_TIMESTAMP(USER_TRACK.USER_TIME_BEST) AS USER_TIME_BEST, ";
    $sql.= "UNIX_TIMESTAMP(USER_TRACK.USER_TIME_TOTAL) AS USER_TIME_TOTAL, ";
    $sql.= "USER_PEER.RELATIONSHIP, SESSIONS.HASH FROM USER USER ";
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
    $sql.= "LEFT JOIN SESSIONS ON (SESSIONS.UID = USER.UID ";
    $sql.= "AND SESSIONS.TIME >= FROM_UNIXTIME($session_stamp)) ";
    $sql.= "WHERE USER.UID = '$uid' ";
    $sql.= "GROUP BY USER.UID";

    if (!$result = db_query($sql, $db_user_get_profile)) return false;

    if (db_num_rows($result) > 0) {

        $user_profile = db_fetch_array($result);

        if (isset($user_profile['FORUM_ANON_LOGON']) && $user_profile['FORUM_ANON_LOGON'] > USER_ANON_DISABLED) {
            $anon_logon = $user_profile['FORUM_ANON_LOGON'];
        }elseif (isset($user_profile['GLOBAL_ANON_LOGON']) && $user_profile['GLOBAL_ANON_LOGON'] > USER_ANON_DISABLED) {
            $anon_logon = $user_profile['GLOBAL_ANON_LOGON'];
        }else {
            $anon_logon = USER_ANON_DISABLED;
        }

        if ($anon_logon == USER_ANON_DISABLED && isset($user_profile['LAST_VISIT']) && $user_profile['LAST_VISIT'] > 0) {
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

        if (isset($user_prefs['DOB_DISPLAY']) && $user_prefs['DOB_DISPLAY'] == USER_DOB_DISPLAY_DATE && !empty($user_prefs['DOB']) && $user_prefs['DOB'] != "0000-00-00") {
            $user_profile['DOB'] = format_birthday($user_prefs['DOB']);
        }

        if (isset($user_prefs['DOB_DISPLAY']) && $user_prefs['DOB_DISPLAY'] == USER_DOB_DISPLAY_BOTH && !empty($user_prefs['DOB']) && $user_prefs['DOB'] != "0000-00-00") {
            $user_profile['DOB'] = format_birthday($user_prefs['DOB']);
        }

        if (isset($user_prefs['DOB_DISPLAY']) && $user_prefs['DOB_DISPLAY'] > USER_DOB_DISPLAY_NONE && $user_prefs['DOB_DISPLAY'] < USER_DOB_DISPLAY_BOTH && !empty($user_prefs['DOB']) && $user_prefs['DOB'] != "0000-00-00") {
            $user_profile['AGE'] = format_age($user_prefs['DOB']);
        }

        if (isset($user_prefs['PIC_URL']) && strlen($user_prefs['PIC_URL']) > 0) {
            $user_profile['PIC_URL'] = $user_prefs['PIC_URL'];
        }

        if (isset($user_prefs['PIC_AID']) && is_md5($user_prefs['PIC_AID'])) {
            $user_profile['PIC_AID'] = $user_prefs['PIC_AID'];
        }

        if (isset($user_prefs['AVATAR_URL']) && strlen($user_prefs['AVATAR_URL']) > 0) {
            $user_profile['AVATAR_URL'] = $user_prefs['AVATAR_URL'];
        }

        if (isset($user_prefs['AVATAR_AID']) && is_md5($user_prefs['AVATAR_AID'])) {
            $user_profile['AVATAR_AID'] = $user_prefs['AVATAR_AID'];
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

        if ($anon_logon == USER_ANON_DISABLED) {

            if (isset($user_profile['HASH']) && is_md5($user_profile['HASH'])) {

                $user_profile['STATUS'] = $lang['useractive'];

            }else {

                $user_profile['STATUS'] = $lang['userinactive'];

            }

        }else {

            $user_profile['STATUS'] = $lang['unknown'];
        }

        $user_profile['POST_COUNT'] = user_get_post_count($uid);

        $user_profile['LOCAL_TIME'] = user_format_local_time($user_prefs);

        return $user_profile;
    }

    return false;
}

function user_format_local_time(&$user_prefs_array)
{
    $lang = load_language_file();

    if (isset($user_prefs_array['TIMEZONE']) && is_numeric($user_prefs_array['TIMEZONE'])) {
        $timezone_id = $user_prefs_array['TIMEZONE'];
    }else {
        $timezone_id = forum_get_setting('forum_timezone', false, 27);
    }

    if (isset($user_prefs_array['GMT_OFFSET']) && is_numeric($user_prefs_array['GMT_OFFSET'])) {
        $gmt_offset = $user_prefs_array['GMT_OFFSET'];
    }else {
        $gmt_offset = forum_get_setting('forum_gmt_offset', false, 0);
    }

    if (isset($user_prefs_array['DST_OFFSET']) && is_numeric($user_prefs_array['DST_OFFSET'])) {
        $dst_offset = $user_prefs_array['DST_OFFSET'];
    }else {
        $dst_offset = forum_get_setting('forum_dst_offset', false, 0);
    }

    if (isset($user_prefs_array['DL_SAVING']) && user_check_pref('DL_SAVING', $user_prefs_array['DL_SAVING'])) {
        $dl_saving = $user_prefs_array['DL_SAVING'];
    }else {
        $dl_saving = forum_get_setting('forum_dl_saving', false, 'N');
    }

    if ($dl_saving == "Y" && timestamp_is_dst($timezone_id, $gmt_offset)) {
        $local_time = time() + ($gmt_offset * HOUR_IN_SECONDS) + ($dst_offset * HOUR_IN_SECONDS);
    }else {
        $local_time = time() + ($gmt_offset * HOUR_IN_SECONDS);
    }

    $date_string = gmdate("s i G j n Y", $local_time);

    list($sec, $min, $hour, $day, $month, $year) = explode(" ", $date_string);

    $month_str = $lang['month_short'][$month];

    return sprintf($lang['daymonthyearhourminute'], $day, $month_str, $year, $hour, $min); // j M Y H:i
}

function user_get_profile_entries($uid)
{
    $db_user_get_profile_entries = db_connect();

    if (!is_numeric($uid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $user_profile_array = array();

    $session_uid = bh_session_get_value('UID');

    $peer_relationship = user_get_relationship($uid, $session_uid);

    $user_friend = USER_FRIEND;

    $sql = "SELECT PROFILE_SECTION.PSID, PROFILE_ITEM.PIID, PROFILE_ITEM.NAME, ";
    $sql.= "PROFILE_ITEM.TYPE, USER_PROFILE.ENTRY, USER_PROFILE.PRIVACY ";
    $sql.= "FROM {$table_data['PREFIX']}PROFILE_SECTION PROFILE_SECTION ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}PROFILE_ITEM PROFILE_ITEM ";
    $sql.= "ON (PROFILE_ITEM.PSID = PROFILE_SECTION.PSID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PROFILE USER_PROFILE ";
    $sql.= "ON (USER_PROFILE.PIID = PROFILE_ITEM.PIID AND USER_PROFILE.UID = '$uid' ";
    $sql.= "AND (USER_PROFILE.PRIVACY = 0 OR USER_PROFILE.UID = '$session_uid' ";
    $sql.= "OR (USER_PROFILE.PRIVACY = 1 AND ($peer_relationship & $user_friend > 0)))) ";
    $sql.= "WHERE USER_PROFILE.ENTRY IS NOT NULL AND LENGTH(USER_PROFILE.ENTRY) > 0 ";
    $sql.= "ORDER BY PROFILE_SECTION.POSITION, PROFILE_ITEM.POSITION, PROFILE_ITEM.PIID";

    if (!$result = db_query($sql, $db_user_get_profile_entries)) return false;

    if (db_num_rows($result) > 0) {

        while ($user_profile_data = db_fetch_array($result)) {

            if (($user_profile_data['TYPE'] == PROFILE_ITEM_RADIO) || ($user_profile_data['TYPE'] == PROFILE_ITEM_DROPDOWN)) {

                if (@list($field_name, $field_values) = explode(':', $user_profile_data['NAME'])) {

                    $field_values = explode(';', $field_values);

                    if (isset($user_profile_data['ENTRY']) && isset($field_values[$user_profile_data['ENTRY']])) {

                        $user_profile_array[$user_profile_data['PSID']][$user_profile_data['PIID']] = $user_profile_data;
                    }
                }

            }else {

                $user_profile_array[$user_profile_data['PSID']][$user_profile_data['PIID']] = $user_profile_data;
            }
        }
    }

    return sizeof($user_profile_array) > 0 ? $user_profile_array : false;
}

function user_get_profile_image($uid)
{
    $db_user_get_profile_image = db_connect();

    if (!is_numeric($uid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT PIC_URL FROM {$table_data['PREFIX']}USER_PREFS WHERE UID = '$uid'";

    if (!$result = db_query($sql, $db_user_get_profile_image)) return false;

    if (db_num_rows($result) > 0) {

        $user_profile_data = db_fetch_array($result);

        if (isset($user_profile_data['PIC_URL']) && strlen($user_profile_data['PIC_URL']) > 0) {
            return $user_profile_data['PIC_URL'];
        }
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

    if (!$result = db_query($sql, $db_user_get_post_count)) return false;

    if (db_num_rows($result) > 0) {

        $post_count = db_fetch_array($result);

        if (isset($post_count['POST_COUNT']) && !is_null($post_count['POST_COUNT'])) {
            return $post_count['POST_COUNT'];
        }

        $sql = "SELECT COUNT(PID) AS COUNT FROM {$table_data['PREFIX']}POST ";
        $sql.= "WHERE FROM_UID = '$uid'";

        if (!$result = db_query($sql, $db_user_get_post_count)) return false;

        list($post_count) = db_fetch_array($result, DB_RESULT_NUM);

        $sql = "UPDATE {$table_data['PREFIX']}USER_TRACK ";
        $sql.= "SET POST_COUNT = '$post_count' WHERE UID = '$uid'";

        if (!$result = db_query($sql, $db_user_get_post_count)) return false;

        return $post_count;
    }

    $sql = "SELECT COUNT(PID) AS COUNT FROM {$table_data['PREFIX']}POST ";
    $sql.= "WHERE FROM_UID = '$uid'";

    if (!$result = db_query($sql, $db_user_get_post_count)) return false;

    $sql = "INSERT IGNORE INTO {$table_data['PREFIX']}USER_TRACK ";
    $sql.= "(UID, POST_COUNT) VALUES ($uid, $post_count)";

    if (!$result = db_query($sql, $db_user_get_post_count)) return false;

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