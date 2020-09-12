<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

Beehive Forum is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Beehive; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307
USA
======================================================================*/

// Required includes
require_once BH_INCLUDE_PATH . 'banned.inc.php';
require_once BH_INCLUDE_PATH . 'constants.inc.php';
require_once BH_INCLUDE_PATH . 'db.inc.php';
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'forum.inc.php';
require_once BH_INCLUDE_PATH . 'perm.inc.php';
require_once BH_INCLUDE_PATH . 'timezone.inc.php';
require_once BH_INCLUDE_PATH . 'user.inc.php';
require_once BH_INCLUDE_PATH . 'user_rel.inc.php';
// End Required includes

function user_profile_update($uid, $piid, $entry, $privacy)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;
    if (!is_numeric($piid)) return false;
    if (!is_numeric($privacy)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (strlen(trim($entry)) > 0) {

        $entry = $db->escape($entry);

        $sql = "INSERT INTO `{$table_prefix}USER_PROFILE` (UID, PIID, ENTRY, PRIVACY) ";
        $sql .= "VALUES ('$uid', '$piid', '$entry', '$privacy') ON DUPLICATE KEY UPDATE ";
        $sql .= "ENTRY = VALUES(ENTRY), PRIVACY = VALUES(PRIVACY)";

        if (!$db->query($sql)) return false;

    } else {

        $sql = "DELETE FROM `{$table_prefix}USER_PROFILE` ";
        $sql .= "WHERE UID = '$uid' AND PIID = '$piid'";

        if (!$db->query($sql)) return false;
    }

    return true;
}

function user_get_profile($uid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!($forum_fid = get_forum_fid())) return false;

    $user_prefs = user_get_prefs($uid);

    $session_gc_maxlifetime = ini_get('session.gc_maxlifetime');

    $session_cutoff_datetime = date(MYSQL_DATETIME, time() - $session_gc_maxlifetime);

    $sql = "SELECT USER.UID, USER.LOGON, USER.NICKNAME, USER_PEER.PEER_NICKNAME, USER_PEER.RELATIONSHIP, ";
    $sql .= "SESSIONS.ID, UNIX_TIMESTAMP(USER_FORUM.LAST_VISIT) AS LAST_VISIT, UNIX_TIMESTAMP(USER.REGISTERED) AS REGISTERED, ";
    $sql .= "COALESCE(USER_POST_RATING.RATING, 0) AS POST_RATING, COUNT(POST_USER_RATING.RATING) AS POST_VOTE_TOTAL, ";
    $sql .= "COALESCE(SUM(IF(POST_USER_RATING.RATING > 0, 1, 0)), 0) AS POST_VOTE_UP, ";
    $sql .= "COALESCE(SUM(IF(POST_USER_RATING.RATING < 0, 1, 0)), 0) AS POST_VOTE_DOWN FROM USER USER ";
    $sql .= "LEFT JOIN USER_PREFS USER_PREFS_GLOBAL ON (USER_PREFS_GLOBAL.UID = USER.UID) ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_PREFS` USER_PREFS_FORUM ON (USER_PREFS_FORUM.UID = USER.UID) ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ON (USER_PEER.PEER_UID = USER.UID AND USER_PEER.UID = '{$_SESSION['UID']}') ";
    $sql .= "LEFT JOIN USER_FORUM USER_FORUM ON (USER_FORUM.UID = USER.UID AND USER_FORUM.FID = '$forum_fid') ";
    $sql .= "LEFT JOIN SESSIONS ON (SESSIONS.UID = USER.UID AND SESSIONS.TIME >= CAST('$session_cutoff_datetime' AS DATETIME)) ";
    $sql .= "LEFT JOIN `{$table_prefix}POST_RATING` POST_USER_RATING ON (POST_USER_RATING.UID = USER.UID AND POST_USER_RATING.RATING IN (-1, 1)) ";
    $sql .= "LEFT JOIN (SELECT POST.FROM_UID AS UID, SUM(POST_RATING.RATING) AS RATING FROM `{$table_prefix}POST` POST ";
    $sql .= "INNER JOIN `{$table_prefix}POST_RATING` POST_RATING ON (POST_RATING.TID = POST.TID AND POST_RATING.PID = POST.PID) ";
    $sql .= "WHERE POST.FROM_UID = '$uid' GROUP BY POST.FROM_UID) AS USER_POST_RATING ON (USER_POST_RATING.UID = USER.UID) ";
    $sql .= "WHERE USER.UID = '$uid' GROUP BY USER.UID";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $user_profile = $result->fetch_assoc();

    if (isset($user_prefs['ANON_LOGON']) && ($user_prefs['ANON_LOGON'] > USER_ANON_DISABLED)) {
        $anon_logon = $user_prefs['ANON_LOGON'];
    } else {
        $anon_logon = USER_ANON_DISABLED;
    }

    if ($anon_logon == USER_ANON_DISABLED && isset($user_profile['LAST_VISIT']) && $user_profile['LAST_VISIT'] > 0) {
        $user_profile['LAST_LOGON'] = format_date_time($user_profile['LAST_VISIT']);
    } else {
        $user_profile['LAST_LOGON'] = gettext("Unknown");
    }

    if (isset($user_profile['REGISTERED']) && $user_profile['REGISTERED'] > 0) {
        $user_profile['REGISTERED'] = format_date_time($user_profile['REGISTERED']);
    } else {
        $user_profile['REGISTERED'] = gettext("Unknown");
    }

    if (isset($user_prefs['DOB_DISPLAY']) && !empty($user_prefs['DOB']) && $user_prefs['DOB'] != "0000-00-00") {

        if ($user_prefs['DOB_DISPLAY'] == USER_DOB_DISPLAY_BOTH) {

            $user_profile['DOB'] = format_birthday($user_prefs['DOB']);
            $user_profile['AGE'] = format_age($user_prefs['DOB']);

        } else if ($user_prefs['DOB_DISPLAY'] == USER_DOB_DISPLAY_DATE) {

            $user_profile['DOB'] = format_birthday($user_prefs['DOB']);

        } else if ($user_prefs['DOB_DISPLAY'] == USER_DOB_DISPLAY_AGE) {

            $user_profile['AGE'] = format_age($user_prefs['DOB']);
        }
    }

    if (isset($user_prefs['PIC_URL']) && filter_var($user_prefs['PIC_URL'], FILTER_VALIDATE_URL)) {
        $user_profile['PIC_URL'] = $user_prefs['PIC_URL'];
    }

    if (isset($user_prefs['PIC_AID']) && is_numeric($user_prefs['PIC_AID'])) {
        $user_profile['PIC_AID'] = $user_prefs['PIC_AID'];
    }

    if (isset($user_prefs['AVATAR_URL']) && filter_var($user_prefs['AVATAR_URL'], FILTER_VALIDATE_URL)) {
        $user_profile['AVATAR_URL'] = $user_prefs['AVATAR_URL'];
    }

    if (isset($user_prefs['AVATAR_AID']) && is_numeric($user_prefs['AVATAR_AID'])) {
        $user_profile['AVATAR_AID'] = $user_prefs['AVATAR_AID'];
    }

    if (isset($user_prefs['HOMEPAGE_URL']) && filter_var($user_prefs['HOMEPAGE_URL'], FILTER_VALIDATE_URL)) {
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

        if (isset($user_profile['ID'])) {

            $user_profile['STATUS'] = gettext("Online");

        } else {

            $user_profile['STATUS'] = gettext("Inactive / Offline");

        }

    } else {

        $user_profile['STATUS'] = gettext("Unknown");
    }

    if (($user_post_count = user_get_post_count($uid)) !== false) {
        $user_profile['POST_COUNT'] = $user_post_count;
    } else {
        $user_profile['POST_COUNT'] = 0;
    }

    if (($user_local_time = user_format_local_time($user_prefs)) !== false) {
        $user_profile['LOCAL_TIME'] = $user_local_time;
    } else {
        $user_profile['LOCAL_TIME'] = gettext("Unknown");
    }

    if (user_is_banned($uid)) {

        $user_profile['GROUPS'] = gettext("Banned");

    } else {

        if (($user_groups_array = perm_user_get_group_names($uid))) {
            $user_profile['GROUPS'] = implode(', ', $user_groups_array);
        } else {
            $user_profile['GROUPS'] = gettext("Registered");
        }
    }

    return $user_profile;
}

function user_format_local_time(&$user_prefs_array)
{
    if (isset($user_prefs_array['TIMEZONE']) && is_numeric($user_prefs_array['TIMEZONE'])) {
        $timezone_id = $user_prefs_array['TIMEZONE'];
    } else {
        $timezone_id = forum_get_setting('forum_timezone', null, 27);
    }

    if (isset($user_prefs_array['GMT_OFFSET']) && is_numeric($user_prefs_array['GMT_OFFSET'])) {
        $gmt_offset = $user_prefs_array['GMT_OFFSET'];
    } else {
        $gmt_offset = forum_get_setting('forum_gmt_offset', null, 0);
    }

    if (isset($user_prefs_array['DST_OFFSET']) && is_numeric($user_prefs_array['DST_OFFSET'])) {
        $dst_offset = $user_prefs_array['DST_OFFSET'];
    } else {
        $dst_offset = forum_get_setting('forum_dst_offset', null, 0);
    }

    if (isset($user_prefs_array['DL_SAVING']) && user_check_pref('DL_SAVING', $user_prefs_array['DL_SAVING'])) {
        $dl_saving = $user_prefs_array['DL_SAVING'];
    } else {
        $dl_saving = forum_get_setting('forum_dl_saving', null, 'N');
    }

    if ($dl_saving == "Y" && timestamp_is_dst($timezone_id, $gmt_offset)) {
        $local_time = time() + ($gmt_offset * HOUR_IN_SECONDS) + ($dst_offset * HOUR_IN_SECONDS);
    } else {
        $local_time = time() + ($gmt_offset * HOUR_IN_SECONDS);
    }

    return strftime('%#d %b %Y %H:%M', $local_time);
}

function user_get_profile_entries($uid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $user_profile_array = array();

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    $peer_relationship = user_get_relationship($uid, $_SESSION['UID']);

    $user_friend = USER_FRIEND;

    $sql = "SELECT PROFILE_SECTION.PSID, PROFILE_ITEM.PIID, PROFILE_ITEM.NAME, ";
    $sql .= "PROFILE_ITEM.TYPE, PROFILE_ITEM.OPTIONS, USER_PROFILE.ENTRY, USER_PROFILE.PRIVACY ";
    $sql .= "FROM `{$table_prefix}PROFILE_SECTION` PROFILE_SECTION ";
    $sql .= "LEFT JOIN `{$table_prefix}PROFILE_ITEM` PROFILE_ITEM ";
    $sql .= "ON (PROFILE_ITEM.PSID = PROFILE_SECTION.PSID) ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_PROFILE` USER_PROFILE ";
    $sql .= "ON (USER_PROFILE.PIID = PROFILE_ITEM.PIID AND USER_PROFILE.UID = '$uid') ";
    $sql .= "WHERE USER_PROFILE.ENTRY IS NOT NULL AND (USER_PROFILE.PRIVACY = 0 ";
    $sql .= "OR (USER_PROFILE.PRIVACY = 1 AND ($peer_relationship & $user_friend > 0)) ";
    $sql .= "OR (USER_PROFILE.PRIVACY = 2 AND USER_PROFILE.UID = '{$_SESSION['UID']}')) ";
    $sql .= "ORDER BY PROFILE_SECTION.POSITION, PROFILE_ITEM.POSITION, PROFILE_ITEM.PIID";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    while (($user_profile_data = $result->fetch_assoc()) !== null) {

        if (strlen(trim($user_profile_data['ENTRY'])) > 0) {

            if (($user_profile_data['TYPE'] == PROFILE_ITEM_RADIO) || ($user_profile_data['TYPE'] == PROFILE_ITEM_DROPDOWN)) {

                $profile_item_options_array = explode("\n", $user_profile_data['OPTIONS']);

                if (isset($profile_item_options_array[$user_profile_data['ENTRY']])) {
                    $user_profile_array[$user_profile_data['PSID']][$user_profile_data['PIID']] = $user_profile_data;
                }

            } else {

                $user_profile_array[$user_profile_data['PSID']][$user_profile_data['PIID']] = $user_profile_data;
            }
        }
    }

    return sizeof($user_profile_array) > 0 ? $user_profile_array : false;
}

function user_get_profile_image($uid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT COALESCE(USER_PREFS_FORUM.PIC_URL, USER_PREFS_GLOBAL.PIC_URL) AS PIC_URL ";
    $sql .= "FROM USER LEFT JOIN USER_PREFS USER_PREFS_GLOBAL ON (USER_PREFS_GLOBAL.UID = USER.UID) ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_PREFS` USER_PREFS_FORUM ";
    $sql .= "ON (USER_PREFS_FORUM.UID = USER.UID) WHERE USER.UID = '$uid'";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $user_profile_data = $result->fetch_assoc();

    if (!isset($user_profile_data['PIC_URL']) || !filter_var($user_profile_data['PIC_URL'], FILTER_VALIDATE_URL)) {
        return false;
    }

    return $user_profile_data['PIC_URL'];
}

function user_get_post_count($uid)
{
    if (!is_numeric($uid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!$db = db::get()) return false;

    $sql = "SELECT USER_VALUE FROM `{$table_prefix}USER_TRACK` ";
    $sql .= "WHERE UID = '$uid' AND USER_KEY = 'POST_COUNT' ";
    $sql .= "AND USER_VALUE IS NOT NULL";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows > 0) {

        list($post_count) = $result->fetch_row();
        return $post_count;
    }

    $sql = "INSERT IGNORE INTO `{$table_prefix}USER_TRACK` (UID, USER_KEY, USER_VALUE) ";
    $sql .= "SELECT '$uid', 'POST_COUNT', COUNT(POST.PID) AS POST_COUNT FROM `{$table_prefix}POST` POST ";
    $sql .= "WHERE FROM_UID = '$uid' ON DUPLICATE KEY UPDATE USER_VALUE = VALUES(USER_VALUE)";

    if (!($result = $db->query($sql))) return false;

    return user_get_post_count($uid);
}

function user_profile_popup_callback($logon)
{
    $webtag = get_webtag();

    forum_check_webtag_available($webtag);

    return "<a href=\"user_profile.php?webtag=$webtag&amp;logon=$logon\" class=\"popup 650x500\" target=\"_blank\">$logon</a>";
}