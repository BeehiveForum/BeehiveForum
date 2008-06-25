<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
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

/* $Id: stats.inc.php,v 1.100 2008-06-25 19:48:39 decoyduck Exp $ */

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "admin.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "folder.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "timezone.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");
include_once(BH_INCLUDE_PATH. "word_filter.inc.php");

function stats_update($session_count, $recent_post_count)
{
    if (!$db_update_stats = db_connect()) return false;

    if (!is_numeric($session_count)) return false;
    if (!is_numeric($recent_post_count)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT ID FROM {$table_data['PREFIX']}STATS ";
    $sql.= "ORDER BY ID DESC LIMIT 0, 1";

    if (!$result = db_query($sql, $db_update_stats)) return false;

    if (db_num_rows($result) > 0) {

        $sql = "UPDATE LOW_PRIORITY {$table_data['PREFIX']}STATS SET ";
        $sql.= "MOST_USERS_DATE = NOW(), MOST_USERS_COUNT = '$session_count' ";
        $sql.= "WHERE MOST_USERS_COUNT < $session_count";

        if (!$result = db_query($sql, $db_update_stats)) return false;

        $sql = "UPDATE LOW_PRIORITY {$table_data['PREFIX']}STATS SET ";
        $sql.= "MOST_POSTS_DATE = NOW(), MOST_POSTS_COUNT = '$recent_post_count' ";
        $sql.= "WHERE MOST_POSTS_COUNT < $recent_post_count";

        if (!$result = db_query($sql, $db_update_stats)) return false;

    }else {

        $sql = "INSERT LOW_PRIORITY INTO {$table_data['PREFIX']}STATS (MOST_USERS_DATE, ";
        $sql.= "MOST_USERS_COUNT, MOST_POSTS_DATE, MOST_POSTS_COUNT) ";
        $sql.= "VALUES (NOW(), '$session_count', NOW(), '$recent_post_count')";

        if (!$result = db_query($sql, $db_update_stats)) return false;
    }

    return true;
}

function stats_output_xml()
{
    // Outputting XML

    header('Content-Type: text/xml', true);

    // Check HTTP cache headers

    header_check_cache();

    // Number of active users

    $session_count = stats_get_active_session_count();

    // Number of recent posts.

    $recent_post_count = stats_get_recent_post_count();

    // Update the stats records.

    stats_update($session_count, $recent_post_count);

    // Output the XML document.

    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
    echo "<stats>\n";
    echo "  <users>\n";

    if ($user_count = user_count()) {
        echo sprintf("    <count>%s</count>\n", html_entity_to_decimal(number_format($user_count, 0, ",", ",")));
    }

    if ($user_stats = stats_get_active_user_list()) {

        echo "    <active>\n";
        echo "      <guests>", html_entity_to_decimal($user_stats['GUESTS']), "</guests>\n";
        echo "      <visible>", html_entity_to_decimal($user_stats['NUSERS']), "</visible>\n";
        echo "      <anonymous>", html_entity_to_decimal($user_stats['AUSERS']), "</anonymous>\n";

        if (isset($user_stats['USERS']) && sizeof($user_stats['USERS']) > 0) {

            echo "    <list>\n";

            foreach ($user_stats['USERS'] as $active_user) {

                $active_user['DISPLAY'] = _htmlentities(format_user_name($active_user['LOGON'], $active_user['NICKNAME']));

                echo "      <user>\n";
                echo "        <uid>", html_entity_to_decimal($active_user['UID']), "</uid>\n";
                echo "        <display>", word_filter_add_ob_tags(html_entity_to_decimal($active_user['DISPLAY'])), "</display>\n";
                echo "        <relationship>", html_entity_to_decimal($active_user['RELATIONSHIP']), "</relationship>\n";
                echo "        <anonymous>", html_entity_to_decimal($active_user['ANON_LOGON']), "</anonymous>\n";
                echo "      </user>\n";
            }

            echo "    </list>\n";
        }

        echo "    </active>\n";
    }

    if ($newest_user = stats_get_newest_user()) {

        $newest_user['DISPLAY'] = _htmlentities(format_user_name($newest_user['LOGON'], $newest_user['NICKNAME']));

        echo "    <newest>\n";
        echo "      <uid>", html_entity_to_decimal($newest_user['UID']), "</uid>\n";
        echo "      <display>", word_filter_add_ob_tags(html_entity_to_decimal($newest_user['DISPLAY'])), "</display>\n";
        echo "    </newest>\n";
    }

    if ($most_users = stats_get_most_users()) {

        $most_users_count = number_format($most_users['MOST_USERS_COUNT'], 0, ",", ",");
        $most_users_date =  format_time($most_users['MOST_USERS_DATE'], 1);

        echo "    <record>\n";
        echo "      <count>", html_entity_to_decimal($most_users_count), "</count>\n";
        echo "      <date>", html_entity_to_decimal($most_users_date), "</date>\n";
        echo "    </record>\n";
    }

    echo "  </users>\n";
    echo "  <threads>\n";

    if ($thread_count = stats_get_thread_count()) {
        echo sprintf("    <count>%s</count>\n", html_entity_to_decimal(number_format($thread_count, 0, ",", ",")));
    }

    if ($longest_thread = stats_get_longest_thread()) {

        $longest_thread_title = _htmlentities(thread_format_prefix($longest_thread['PREFIX'], $longest_thread['TITLE']));
        $longest_thread_post_count = number_format($longest_thread['LENGTH'], 0, ",", ",");

        echo "    <longest>\n";
        echo "      <tid>", html_entity_to_decimal($longest_thread['TID']), "</tid>\n";
        echo "      <title>", word_filter_add_ob_tags(html_entity_to_decimal($longest_thread_title)), "</title>\n";
        echo "      <length>", html_entity_to_decimal($longest_thread_post_count), "</length>\n";
        echo "    </longest>\n";
    }

    echo "  </threads>\n";
    echo "  <posts>\n";

    if ($post_count = stats_get_post_count()) {
        echo sprintf("    <count>%s</count>\n", html_entity_to_decimal(number_format($post_count, 0, ",", ",")));
    }

    $recent_post_count = number_format($recent_post_count, 0, ",", ",");

    echo "    <recent>\n";
    echo sprintf("    <count>%s</count>\n", number_format($recent_post_count, 0, ",", ","));

    if ($most_posts = stats_get_most_posts()) {

        $most_posts_date = format_time($most_posts['MOST_POSTS_DATE'], 1);
        $most_posts_count = number_format($most_posts['MOST_POSTS_COUNT'], 0, ",", ",");

        echo "      <record>\n";
        echo "        <count>", html_entity_to_decimal($most_posts_count), "</count>\n";
        echo "        <date>", html_entity_to_decimal($most_posts_date), "</date>\n";
        echo "      </record>\n";
    }

    echo "    </recent>\n";
    echo "  </posts>\n";
    echo "</stats>\n";


    exit;
}

function stats_get_active_session_count()
{
    if (!$db_stats_get_active_session_count = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return 0;

    $forum_fid = $table_data['FID'];

    $session_stamp = time() - intval(forum_get_setting('active_sess_cutoff', false, 900));

    $sql = "SELECT COUNT(UID) AS USER_COUNT FROM SESSIONS ";
    $sql.= "WHERE TIME >= FROM_UNIXTIME($session_stamp) ";
    $sql.= "AND FID = '$forum_fid'";

    if (!$result = db_query($sql, $db_stats_get_active_session_count)) return false;

    list($user_count) = db_fetch_array($result, DB_RESULT_NUM);

    return $user_count;
}

function stats_get_registered_user_count()
{
    if (!$db_stats_get_registered_user_count = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return 0;

    $forum_fid = $table_data['FID'];

    $session_stamp = time() - intval(forum_get_setting('active_sess_cutoff', false, 900));

    $sql = "SELECT COUNT(UID) AS REGISTERED_USER_COUNT FROM SESSIONS ";
    $sql.= "WHERE TIME >= FROM_UNIXTIME($session_stamp) ";
    $sql.= "AND FID = '$forum_fid' AND UID > 0";

    if (!$result = db_query($sql, $db_stats_get_registered_user_count)) return false;

    list($registered_user_count) = db_fetch_array($result, DB_RESULT_NUM);

    return $registered_user_count;
}

function stats_get_active_guest_count()
{
    if (!$db_stats_get_active_guest_count = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return 0;

    $forum_fid = $table_data['FID'];

    $session_stamp = time() - intval(forum_get_setting('active_sess_cutoff', false, 900));

    $sql = "SELECT COUNT(UID) AS GUEST_COUNT FROM SESSIONS ";
    $sql.= "WHERE TIME >= FROM_UNIXTIME($session_stamp) ";
    $sql.= "AND FID = '$forum_fid' AND UID = 0";

    if (!$result = db_query($sql, $db_stats_get_active_guest_count)) return false;

    list($guest_count) = db_fetch_array($result, DB_RESULT_NUM);

    return $guest_count;
}

function stats_get_active_user_list()
{
    if (!$db_stats_get_active_user_list = db_connect()) return false;

    $stats = array('GUESTS' => 0, 'NUSERS' => 0,
                   'AUSERS' => 0, 'USERS'  => array());

    if (!$table_data = get_table_prefix()) return $stats;

    $forum_fid = $table_data['FID'];

    $session_stamp = time() - intval(forum_get_setting('active_sess_cutoff', false, 900));

    if (($uid = bh_session_get_value('UID')) === false) return false;

    // Current active number of guests

    $sql = "SELECT COUNT(UID) FROM SESSIONS WHERE UID = 0 ";
    $sql.= "AND SESSIONS.TIME >= FROM_UNIXTIME($session_stamp) ";
    $sql.= "AND SESSIONS.FID = '$forum_fid'";

    if (!$result = db_query($sql, $db_stats_get_active_user_list)) return false;

    list($stats['GUESTS']) = db_fetch_array($result, DB_RESULT_NUM);

    // Curent active users

    $sql = "SELECT SESSIONS.UID, USER.LOGON, USER.NICKNAME, ";
    $sql.= "USER_PREFS_GLOBAL.ANON_LOGON AS ANON_LOGON_GLOBAL, ";
    $sql.= "USER_PREFS.ANON_LOGON, USER_PEER.RELATIONSHIP AS PEER_RELATIONSHIP, ";
    $sql.= "USER_PEER2.RELATIONSHIP AS USER_RELATIONSHIP, USER_PEER2.PEER_NICKNAME ";
    $sql.= "FROM SESSIONS SESSIONS LEFT JOIN USER USER ON (USER.UID = SESSIONS.UID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER ";
    $sql.= "ON (USER_PEER.UID = SESSIONS.UID AND USER_PEER.PEER_UID = '$uid') ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER2 ";
    $sql.= "ON (USER_PEER2.PEER_UID = SESSIONS.UID AND USER_PEER2.UID = '$uid') ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PREFS USER_PREFS ON (USER_PREFS.UID = SESSIONS.UID) ";
    $sql.= "LEFT JOIN USER_PREFS USER_PREFS_GLOBAL ON (USER_PREFS_GLOBAL.UID = SESSIONS.UID) ";
    $sql.= "WHERE SESSIONS.TIME >= FROM_UNIXTIME($session_stamp) AND SESSIONS.FID = '$forum_fid' ";
    $sql.= "AND SESSIONS.UID > 0 GROUP BY SESSIONS.UID ORDER BY USER.NICKNAME";

    if (!$result = db_query($sql, $db_stats_get_active_user_list)) return false;

    while ($user_data = db_fetch_array($result)) {

        if (isset($user_data['ANON_LOGON']) && $user_data['ANON_LOGON'] > USER_ANON_DISABLED) {
            $anon_logon = $user_data['ANON_LOGON'];
        }elseif (isset($user_data['ANON_LOGON_GLOBAL']) && $user_data['ANON_LOGON_GLOBAL'] > USER_ANON_DISABLED) {
            $anon_logon = $user_data['ANON_LOGON_GLOBAL'];
        }else {
            $anon_logon = USER_ANON_DISABLED;
        }

        if (!isset($user_data['USER_RELATIONSHIP'])) {
            $user_data['USER_RELATIONSHIP'] = USER_NORMAL;
        }

        if (!isset($user_data['PEER_RELATIONSHIP'])) {
            $user_data['PEER_RELATIONSHIP'] = USER_NORMAL;
        }

        if (isset($user_data['LOGON']) && isset($user_data['PEER_NICKNAME'])) {
            if (!is_null($user_data['PEER_NICKNAME']) && strlen($user_data['PEER_NICKNAME']) > 0) {
                $user_data['NICKNAME'] = $user_data['PEER_NICKNAME'];
            }
        }

        if (!isset($user_data['LOGON'])) $user_data['LOGON'] = $lang['unknownuser'];
        if (!isset($user_data['NICKNAME'])) $user_data['NICKNAME'] = "";

        if ($anon_logon > USER_ANON_DISABLED) {
            $stats['AUSERS']++;
        }else {
            $stats['NUSERS']++;
        }

        if (($user_data['USER_RELATIONSHIP'] & USER_IGNORED_COMPLETELY) > 0) {

            unset($user_data);

        }elseif ($anon_logon == USER_ANON_DISABLED || $user_data['UID'] == $uid || (($user_data['PEER_RELATIONSHIP'] & USER_FRIEND) > 0 && $anon_logon == USER_ANON_FRIENDS_ONLY)) {

            $stats['USERS'][$user_data['UID']] = array('UID'          => $user_data['UID'],
                                                       'LOGON'        => $user_data['LOGON'],
                                                       'NICKNAME'     => $user_data['NICKNAME'],
                                                       'RELATIONSHIP' => $user_data['USER_RELATIONSHIP'],
                                                       'ANON_LOGON'   => $anon_logon);
        }
    }

    $stats['USER_COUNT'] = sizeof($stats['USERS']) + $stats['AUSERS'];
    $stats['USER_COUNT']+= $stats['NUSERS'] + $stats['GUESTS'];

    return $stats;
}

function stats_get_thread_count()
{
    if (!$db_stats_get_thread_count = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return 0;

    $sql = "SELECT COUNT(THREAD.TID) AS THREAD_COUNT ";
    $sql.= "FROM {$table_data['PREFIX']}THREAD THREAD";

    if (!$result = db_query($sql, $db_stats_get_thread_count)) return false;

    if (db_num_rows($result) > 0) {

        list($thread_count) = db_fetch_array($result, DB_RESULT_NUM);
        return $thread_count;
    }

    return 0;
}

function stats_get_post_count()
{
    if (!$db_stats_get_post_count = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return 0;

    $sql = "SELECT COUNT(POST.PID) AS POST_COUNT FROM {$table_data['PREFIX']}POST POST";

    if (!$result = db_query($sql, $db_stats_get_post_count)) return false;

    if (db_num_rows($result) > 0) {

        list($post_count) = db_fetch_array($result, DB_RESULT_NUM);
        return $post_count;
    }

    return 0;
}

function stats_get_recent_post_count()
{
    if (!$db_stats_get_recent_post_count = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return 0;

    $post_stamp = time() - HOUR_IN_SECONDS;

    $sql = "SELECT COUNT(POST.PID) AS POSTS FROM {$table_data['PREFIX']}POST POST ";
    $sql.= "WHERE CREATED >= FROM_UNIXTIME($post_stamp)";

    if (!$result = db_query($sql, $db_stats_get_recent_post_count)) return false;

    if (db_num_rows($result) > 0) {

        list($post_count) = db_fetch_array($result, DB_RESULT_NUM);
        return $post_count;
    }

    return 0;
}

function stats_get_longest_thread()
{
    if (!$db_stats_get_longest_thread = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    // Get the folders the user can see.

    $folders = folder_get_available();

    // Find the longest thread.

    $sql = "SELECT MAX(LENGTH) FROM {$table_data['PREFIX']}THREAD ";
    $sql.= "WHERE FID IN ($folders)";

    if (!$result = db_query($sql, $db_stats_get_longest_thread)) return false;

    list($highest_thread_count) = db_fetch_array($result, DB_RESULT_NUM);

    $sql = "SELECT THREAD.TITLE, THREAD.TID, THREAD.LENGTH, FOLDER.PREFIX ";
    $sql.= "FROM {$table_data['PREFIX']}THREAD THREAD ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}FOLDER FOLDER ";
    $sql.= "ON (FOLDER.FID = THREAD.FID) ";
    $sql.= "WHERE THREAD.LENGTH = '$highest_thread_count' ";
    $sql.= "AND THREAD.DELETED = 'N' ";
    $sql.= "LIMIT 0, 1";

    if (!$result = db_query($sql, $db_stats_get_longest_thread)) return false;

    if (db_num_rows($result) > 0) {

        $thread_data = db_fetch_array($result);
        return $thread_data;
    }

    return false;
}

function stats_get_most_users()
{
    if (!$db_stats_get_most_users = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT MOST_USERS_COUNT, UNIX_TIMESTAMP(MOST_USERS_DATE) AS MOST_USERS_DATE ";
    $sql.= "FROM {$table_data['PREFIX']}STATS";

    if (!$result = db_query($sql, $db_stats_get_most_users)) return false;

    if (db_num_rows($result) > 0) {

        $user_data = db_fetch_array($result);
        return $user_data;
    }

    return false;
}

function stats_get_most_posts()
{
    if (!$db_stats_get_most_posts = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT MOST_POSTS_COUNT, UNIX_TIMESTAMP(MOST_POSTS_DATE) AS MOST_POSTS_DATE ";
    $sql.= "FROM {$table_data['PREFIX']}STATS";

    if (!$result = db_query($sql, $db_stats_get_most_posts)) return false;

    if (db_num_rows($result) > 0) {

        $post_data = db_fetch_array($result);
        return $post_data;
    }

    return false;
}

function stats_get_newest_user()
{
    if (!$db_stats_get_newest_user = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $uid = bh_session_get_value('UID');

    $sql = "SELECT MAX(UID) FROM USER";

    if (!$result = db_query($sql, $db_stats_get_newest_user)) return false;

    list($newest_user_uid) = db_fetch_array($result, DB_RESULT_NUM);

    $sql = "SELECT USER.UID, USER.LOGON, USER.NICKNAME, USER_PEER.PEER_NICKNAME ";
    $sql.= "FROM USER LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER ";
    $sql.= "ON (USER_PEER.PEER_UID = USER.UID AND USER_PEER.UID = '$uid') ";
    $sql.= "WHERE USER.UID = '$newest_user_uid'";

    if (!$result = db_query($sql, $db_stats_get_newest_user)) return false;

    if (db_num_rows($result) > 0) {

        $user_data = db_fetch_array($result);

        if (isset($user_data['LOGON']) && isset($user_data['PEER_NICKNAME'])) {
            if (!is_null($user_data['PEER_NICKNAME']) && strlen($user_data['PEER_NICKNAME']) > 0) {
                $user_data['NICKNAME'] = $user_data['PEER_NICKNAME'];
            }
        }

        if (!isset($user_data['LOGON'])) $user_data['LOGON'] = $lang['unknownuser'];
        if (!isset($user_data['NICKNAME'])) $user_data['NICKNAME'] = "";

        return $user_data;
    }

    return false;
}

function stats_get_post_tallys($start_stamp, $end_stamp)
{
    if (!$db_stats_get_post_tallys = db_connect()) return false;

    $lang = load_language_file();

    if (!is_numeric($start_stamp)) return false;
    if (!is_numeric($end_stamp)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $post_tallys = array('user_stats' => array(), 'post_count' => 0);

    $uid = bh_session_get_value('UID');

    $sql = "SELECT COUNT(POST.PID) AS TOTAL_POST_COUNT ";
    $sql.= "FROM {$table_data['PREFIX']}POST POST ";
    $sql.= "WHERE POST.CREATED > FROM_UNIXTIME($start_stamp) ";
    $sql.= "AND POST.CREATED < FROM_UNIXTIME($end_stamp)";

    if (!$result = db_query($sql, $db_stats_get_post_tallys)) return false;

    list($post_tallys['post_count']) = db_fetch_array($result, DB_RESULT_NUM);

    $sql = "SELECT POST.FROM_UID AS UID, USER.LOGON, USER.NICKNAME, ";
    $sql.= "USER_PEER.PEER_NICKNAME, COUNT(POST.PID) AS POST_COUNT ";
    $sql.= "FROM {$table_data['PREFIX']}POST POST ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = POST.FROM_UID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER ";
    $sql.= "ON (USER_PEER.PEER_UID = USER.UID AND USER_PEER.UID = '$uid') ";
    $sql.= "WHERE POST.CREATED >= FROM_UNIXTIME($start_stamp) ";
    $sql.= "AND POST.CREATED <= FROM_UNIXTIME($end_stamp) ";
    $sql.= "GROUP BY USER.UID ORDER BY POST_COUNT DESC ";
    $sql.= "LIMIT 0, 20";

    if (!$result = db_query($sql, $db_stats_get_post_tallys)) return false;

    if (db_num_rows($result) > 0) {

        while ($user_stats = db_fetch_array($result)) {

            if (isset($user_stats['LOGON']) && isset($user_stats['PEER_NICKNAME'])) {
                if (!is_null($user_stats['PEER_NICKNAME']) && strlen($user_stats['PEER_NICKNAME']) > 0) {
                    $user_stats['NICKNAME'] = $user_stats['PEER_NICKNAME'];
                }
            }

            if (!isset($user_stats['LOGON'])) $user_stats['LOGON'] = $lang['unknownuser'];
            if (!isset($user_stats['NICKNAME'])) $user_stats['NICKNAME'] = "";

            $post_tallys['user_stats'][] = $user_stats;
        }
    }

    return $post_tallys;
}

function stats_get_top_poster()
{
    if (!$db_stats_get_top_poster = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT POST.FROM_UID AS UID, USER.LOGON, USER.NICKNAME, ";
    $sql.= "COUNT(POST.PID) AS POST_COUNT FROM {$table_data['PREFIX']}POST POST ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = POST.FROM_UID) ";
    $sql.= "GROUP BY USER.UID ORDER BY POST_COUNT DESC ";
    $sql.= "LIMIT 0, 1";

    if (!$result = db_query($sql, $db_stats_get_top_poster)) return false;

    if (db_num_rows($result) > 0) {

        $user_data = db_fetch_array($result);

        return $user_data;
    }

    return false;
}

function stats_get_folder_count()
{
    if (!$db_stats_get_folder_count = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT COUNT(FID) AS FOLDER_COUNT FROM {$table_data['PREFIX']}FOLDER";

    if (!$result = db_query($sql, $db_stats_get_folder_count)) return false;

    list($folder_count) = db_fetch_array($result, DB_RESULT_NUM);

    return $folder_count;
}

function stats_get_folder_with_most_threads()
{
    if (!$db_stats_get_folder_with_most_threads = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT FOLDER.FID, FOLDER.TITLE, COUNT(THREAD.TID) AS THREAD_COUNT ";
    $sql.= "FROM {$table_data['PREFIX']}THREAD THREAD ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}FOLDER FOLDER ON (FOLDER.FID = THREAD.FID) ";
    $sql.= "GROUP BY THREAD.FID ORDER BY THREAD_COUNT DESC ";
    $sql.= "LIMIT 0, 1";

    if (!$result = db_query($sql, $db_stats_get_folder_with_most_threads)) return false;

    if (db_num_rows($result) > 0) {

        $folder_data = db_fetch_array($result);

        return $folder_data;
    }

    return false;
}

function stats_get_folder_with_most_posts()
{
    if (!$db_stats_get_folder_with_most_posts = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT FOLDER.FID, FOLDER.TITLE, COUNT(POST.PID) AS POST_COUNT ";
    $sql.= "FROM {$table_data['PREFIX']}FOLDER FOLDER ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}THREAD THREAD ON (THREAD.FID = FOLDER.FID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}POST POST ON (POST.TID = THREAD.TID) ";
    $sql.= "GROUP BY FOLDER.FID ORDER BY POST_COUNT DESC ";
    $sql.= "LIMIT 0, 1";

    if (!$result = db_query($sql, $db_stats_get_folder_with_most_posts)) return false;

    if (db_num_rows($result) > 0) {

        $folder_data = db_fetch_array($result);

        return $folder_data;
    }

    return false;
}

function stats_get_folders_by_popularity($offset)
{
    if (!$db_stats_get_folders_by_popularity = db_connect()) return false;

    if (!is_numeric($offset)) $offset = 0;

    if (!$table_data = get_table_prefix()) return false;

    $folder_array = array();

    $sql = "SELECT SQL_CALC_FOUND_ROWS FOLDER.FID, FOLDER.TITLE, ";
    $sql.= "COUNT(POST.PID) AS POST_COUNT FROM {$table_data['PREFIX']}FOLDER FOLDER ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}THREAD THREAD ON (THREAD.FID = FOLDER.FID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}POST POST ON (POST.TID = THREAD.TID) ";
    $sql.= "GROUP BY FOLDER.FID ORDER BY POST_COUNT DESC";

    if (!$result = db_query($sql, $db_stats_get_folders_by_popularity)) return false;

    // Fetch the number of total results

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!$result_count = db_query($sql, $db_stats_get_folders_by_popularity)) return false;

    list($folder_count) = db_fetch_array($result_count, DB_RESULT_NUM);

    if (db_num_rows($result) > 0) {

        while ($folder_data = db_fetch_array($result)) {

            $folder_array[$folder_data['FID']] = $folder_data;
        }

    }else if ($thread_count > 0) {

        $offset = floor(($thread_count - 1) / 20) * 20;
        return stats_get_folders_by_popularity($offset);
    }

    return array('folder_count' => $folder_count,
                 'folder_array' => $folder_array);
}

function stats_get_most_read_thread()
{
    if (!$db_stats_get_most_read_threads = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $thread_array = array();

    $sql = "SELECT THREAD.TID, THREAD.TITLE, FOLDER.PREFIX, THREAD_STATS.VIEWCOUNT ";
    $sql.= "FROM {$table_data['PREFIX']}THREAD_STATS THREAD_STATS ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}THREAD THREAD ";
    $sql.= "ON (THREAD.TID = THREAD_STATS.TID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}FOLDER FOLDER ";
    $sql.= "ON (FOLDER.FID = THREAD.FID) ";
    $sql.= "ORDER BY THREAD_STATS.VIEWCOUNT DESC ";
    $sql.= "LIMIT 0, 1";

    if (!$result = db_query($sql, $db_stats_get_most_read_threads)) return false;

    if (db_num_rows($result) > 0) {

        $thread_data = db_fetch_array($result);

        return $thread_data;
    }

    return false;
}

function stats_get_most_read_threads($offset)
{
    if (!$db_stats_get_most_read_threads = db_connect()) return false;

    if (!is_numeric($offset)) $offset = 0;

    if (!$table_data = get_table_prefix()) return false;

    $thread_array = array();

    $sql = "SELECT SQL_CALC_FOUND_ROWS THREAD.TID, THREAD.TITLE ";
    $sql.= "FROM {$table_data['PREFIX']}THREAD_STATS THREAD_STATS ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}THREAD THREAD ";
    $sql.= "ON (THREAD.TID = THREAD_STATS.TID) ";
    $sql.= "ORDER BY THREAD_STATS.VIEWCOUNT DESC ";
    $sql.= "LIMIT $offset, 20";

    if (!$result = db_query($sql, $db_stats_get_most_read_threads)) return false;

    // Fetch the number of total results

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!$result_count = db_query($sql, $db_stats_get_most_read_threads)) return false;

    list($thread_count) = db_fetch_array($result_count, DB_RESULT_NUM);

    if (db_num_rows($result) > 0) {

        while ($thread_data = db_fetch_array($result)) {

            $thread_array[$thread_data['TID']] = $thread_data;
        }

    }else if ($thread_count > 0) {

        $offset = floor(($thread_count - 1) / 20) * 20;
        return stats_get_most_read_threads($offset);
    }

    return array('thread_count' => $thread_count,
                 'thread_array' => $thread_array);
}

function stats_get_thread_subscription_count()
{
    if (!$db_stats_get_thread_subscription_count = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT COUNT(TID) AS SUBSCRIPTION_COUNT FROM {$table_data['PREFIX']}USER_THREAD WHERE INTEREST = 2";

    if (!$result = db_query($sql, $db_stats_get_thread_subscription_count)) return false;

    list($subscription_count) = db_fetch_array($result, DB_RESULT_NUM);

    return $subscription_count;
}

function stats_get_most_subscribed_thread()
{
    if (!$db_stats_get_most_subscribed_threads = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $thread_array = array();

    $sql = "SELECT THREAD.TID, THREAD.TITLE, COUNT(USER_THREAD.INTEREST) AS SUBSCRIBERS, ";
    $sql.= "FOLDER.PREFIX FROM {$table_data['PREFIX']}USER_THREAD USER_THREAD ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}THREAD THREAD ON (THREAD.TID = USER_THREAD.TID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}FOLDER FOLDER ON (FOLDER.FID = THREAD.FID) ";
    $sql.= "WHERE USER_THREAD.INTEREST = 2 GROUP BY USER_THREAD.TID ";
    $sql.= "ORDER BY SUBSCRIBERS DESC LIMIT 0, 1";

    if (!$result = db_query($sql, $db_stats_get_most_subscribed_threads)) return false;

    if (db_num_rows($result) > 0) {

        $thread_data = db_fetch_array($result);

        return $thread_data;
    }

    return false;
}

function stats_get_most_subscribed_threads($offset)
{
    if (!$db_stats_get_most_subscribed_threads = db_connect()) return false;

    if (!is_numeric($offset)) $offset = 0;

    if (!$table_data = get_table_prefix()) return false;

    $thread_array = array();

    $sql = "SELECT SQL_CALC_FOUND_ROWS THREAD.TID, THREAD.TITLE, ";
    $sql.= "COUNT(USER_THREAD.INTEREST) AS SUBSCRIBERS ";
    $sql.= "FROM {$table_data['PREFIX']}USER_THREAD USER_THREAD ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}THREAD THREAD ";
    $sql.= "ON (THREAD.TID = USER_THREAD.TID) ";
    $sql.= "WHERE USER_THREAD.INTEREST = 2 ";
    $sql.= "GROUP BY USER_THREAD.TID ";
    $sql.= "ORDER BY SUBSCRIBERS DESC ";
    $sql.= "LIMIT $offset, 20";

    if (!$result = db_query($sql, $db_stats_get_most_subscribed_threads)) return false;

    // Fetch the number of total results

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!$result_count = db_query($sql, $db_stats_get_most_subscribed_threads)) return false;

    list($thread_count) = db_fetch_array($result_count, DB_RESULT_NUM);

    if (db_num_rows($result) > 0) {

        while ($thread_data = db_fetch_array($result)) {

            $thread_array[$thread_data['TID']] = $thread_data;
        }

    }else if ($thread_count > 0) {

        $offset = floor(($thread_count - 1) / 20) * 20;
        return stats_get_most_subscribed_threads($offset);
    }

    return array('thread_count' => $thread_count,
                 'thread_array' => $thread_array);
}

function stats_get_poll_count()
{
    if (!$db_stats_get_poll_count = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT COUNT(TID) AS POLL_COUNT FROM {$table_data['PREFIX']}POLL";

    if (!$result = db_query($sql, $db_stats_get_poll_count)) return false;

    list($poll_count) = db_fetch_array($result, DB_RESULT_NUM);

    return $poll_count;
}

function stats_get_poll_option_count()
{
    if (!$db_stats_get_poll_option_count = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT COUNT(*) AS POLL_OPTION_COUNT FROM {$table_data['PREFIX']}POLL_VOTES";

    if (!$result = db_query($sql, $db_stats_get_poll_option_count)) return false;

    list($poll_option_count) = db_fetch_array($result, DB_RESULT_NUM);

    return $poll_option_count;
}

function stats_get_poll_vote_count()
{
    if (!$db_stats_get_poll_vote_count = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT COUNT(*) AS POLL_VOTE_COUNT FROM {$table_data['PREFIX']}USER_POLL_VOTES";

    if (!$result = db_query($sql, $db_stats_get_poll_vote_count)) return false;

    list($poll_vote_count) = db_fetch_array($result, DB_RESULT_NUM);

    return $poll_vote_count;
}

function stats_get_attachment_count()
{
    if (!$db_stats_get_attachment_count = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    $sql = "SELECT COUNT(*) AS ATTACHMENT_COUNT FROM {$table_data['PREFIX']}POST_ATTACHMENT_IDS PAI ";
    $sql.= "LEFT JOIN POST_ATTACHMENT_FILES PAF ON (PAF.AID = PAI.AID) WHERE PAI.FID = '$forum_fid'";

    if (!$result = db_query($sql, $db_stats_get_attachment_count)) return false;

    list($attachment_count) = db_fetch_array($result, DB_RESULT_NUM);

    return $attachment_count;
}

function stats_get_most_downloaded_attachment()
{
    if (!$db_stats_get_most_downloaded_attachment = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (!$attachment_dir = forum_get_setting('attachment_dir')) return 0;

    $forum_fid = $table_data['FID'];

    $sql = "SELECT PAI.TID, PAI.PID, PAF.FILENAME, PAF.HASH, PAF.DOWNLOADS ";
    $sql.= "FROM {$table_data['PREFIX']}POST_ATTACHMENT_IDS PAI ";
    $sql.= "LEFT JOIN POST_ATTACHMENT_FILES PAF ON (PAF.AID = PAI.AID) ";
    $sql.= "WHERE PAI.FID = '$forum_fid' ";
    $sql.= "ORDER BY PAF.DOWNLOADS DESC ";
    $sql.= "LIMIT $offset, 1";

    if (!$result = db_unbuffered_query($sql, $db_stats_get_most_downloaded_attachment)) return false;

    while ($attachment_data = db_fetch_array($result)) {

        if (@file_exists("$attachment_dir/{$attachment_data['HASH']}")) {

            return $attachment_data;
        }
    }

    return false;
}

function stats_get_most_popular_forum_style()
{
    if (!$db_stats_get_most_popular_forum_style = db_connect()) return false;

    $lang = load_language_file();

    if (!$table_data = get_table_prefix()) return false;

    $forum_default_style = forum_get_setting('default_style', false, $lang['none']);

    $sql = "SELECT STYLE, COUNT(*) AS COUNT FROM USER_PREFS ";
    $sql.= "GROUP BY STYLE ORDER BY COUNT DESC LIMIT 0,1";

    if (!$result = db_query($sql, $db_stats_get_most_popular_forum_style)) return false;

    list($style_name_global, $user_count_global) = db_fetch_array($result, DB_RESULT_NUM);

    $sql = "SELECT STYLE, COUNT(*) AS COUNT FROM {$table_data['PREFIX']}USER_PREFS ";
    $sql.= "GROUP BY STYLE ORDER BY COUNT DESC LIMIT 0,1";

    if (!$result = db_query($sql, $db_stats_get_most_popular_forum_style)) return false;

    list($style_name_forum, $user_count_forum) = db_fetch_array($result, DB_RESULT_NUM);

    if ($user_count_forum > $user_count_global) {

        if (strlen(trim($style_name_forum)) > 0) {

            return array('STYLE' => $style_name_forum,
                         'USER_COUNT' => $user_count_forum);

        }else {

            return array('STYLE' => $forum_default_style,
                         'USER_COUNT' => $user_count_forum);
        }

    }else {

        if (strlen(trim($style_name_forum)) > 0) {

            return array('STYLE' => $style_name_global,
                         'USER_COUNT' => $user_count_forum);

        }else {

            return array('STYLE' => $forum_default_style,
                         'USER_COUNT' => $user_count_forum);
        }
    }
}

function stats_get_most_popular_language()
{
    if (!$db_stats_get_most_popular_language = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_default_language = forum_get_setting('default_language', false, 'en');

    $sql = "SELECT LANGUAGE, COUNT(*) AS COUNT FROM USER_PREFS ";
    $sql.= "GROUP BY LANGUAGE ORDER BY COUNT DESC LIMIT 0,1";

    if (!$result = db_query($sql, $db_stats_get_most_popular_language)) return false;

    list($language_name_global, $user_count_global) = db_fetch_array($result, DB_RESULT_NUM);

    $sql = "SELECT LANGUAGE, COUNT(*) AS COUNT FROM {$table_data['PREFIX']}USER_PREFS ";
    $sql.= "GROUP BY LANGUAGE ORDER BY COUNT DESC LIMIT 0,1";

    if (!$result = db_query($sql, $db_stats_get_most_popular_language)) return false;

    list($language_name_forum, $user_count_forum) = db_fetch_array($result, DB_RESULT_NUM);

    if ($user_count_forum > $user_count_global) {

        if (strlen(trim($language_name_forum)) > 0) {

            return array('LANG' => $language_name_forum,
                         'USER_COUNT' => $user_count_forum);

        }else {

            return array('LANG' => $forum_default_language,
                         'USER_COUNT' => $user_count_forum);
        }

    }else {

        if (strlen(trim($language_name_forum)) > 0) {

            return array('LANG' => $language_name_global,
                         'USER_COUNT' => $user_count_forum);

        }else {

            return array('LANG' => $forum_default_language,
                         'USER_COUNT' => $user_count_forum);
        }
    }
}

function stats_get_most_popular_timezone()
{
    if (!$db_stats_get_most_popular_timezone = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_default_language = forum_get_setting('default_language', false, 'en');

    $sql = "SELECT TIMEZONE, COUNT(*) AS COUNT FROM USER_PREFS ";
    $sql.= "GROUP BY TIMEZONE ORDER BY COUNT DESC LIMIT 0,1";

    if (!$result = db_query($sql, $db_stats_get_most_popular_timezone)) return false;

    list($timezone_id, $user_count) = db_fetch_array($result, DB_RESULT_NUM);

    return array('TIMEZONE'   => timezone_id_to_string($timezone_id),
                 'USER_COUNT' => $user_count);
}

function stats_get_most_active_user()
{
    if (!$db_stats_get_most_active_user = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT USER.UID, USER.LOGON, USER.NICKNAME, ";
    $sql.= "UNIX_TIMESTAMP(USER_TRACK.USER_TIME_TOTAL) AS TOTAL_TIME ";
    $sql.= "FROM {$table_data['PREFIX']}USER_TRACK USER_TRACK ";
    $sql.= "LEFT JOIN USER ON (USER.UID = USER_TRACK.UID) ";
    $sql.= "ORDER BY TOTAL_TIME DESC ";
    $sql.= "LIMIT 0, 1";

    if (!$result = db_query($sql, $db_stats_get_most_active_user)) return false;

    if (db_num_rows($result) > 0) {

        $user_data = db_fetch_array($result);

        return $user_data;
    }

    return false;
}

function stats_get_inactive_user_count()
{
    if (!$db_stats_get_inactive_user_count = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT COUNT(UID) AS USER_COUNT FROM USER ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}POST POST ON (POST.FROM_UID = USER.UID) ";
    $sql.= "WHERE POST.TID IS NULL ";

    if (!$result = db_query($sql, $db_stats_get_inactive_user_count)) return false;

    list($user_count) = db_fetch_array($result, DB_RESULT_NUM);

    return $user_count;
}

function stats_get_active_user_count()
{
    if (!$db_stats_get_active_user_count = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT COUNT(DISTINCT FROM_UID) AS USER_COUNT FROM {$table_data['PREFIX']}POST ";

    if (!$result = db_query($sql, $db_stats_get_active_user_count)) return false;

    list($user_count) = db_fetch_array($result, DB_RESULT_NUM);

    return $user_count;
}

function stats_get_visitor_counts()
{
    if (!$db_stats_get_visitor_counts = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    $sql = "SELECT COUNT(UID) AS VISITOR_COUNT FROM VISITOR_LOG ";
    $sql.= "WHERE DAY(NOW()) = DAY(LAST_LOGON) AND MONTH(NOW()) = MONTH(LAST_LOGON) ";
    $sql.= "AND YEAR(NOW()) = YEAR(LAST_LOGON) AND FORUM = '$forum_fid'";

    if (!$result = db_query($sql, $db_stats_get_active_user_count)) return false;

    list($visitors_today) = db_fetch_array($result, DB_RESULT_NUM);

    $sql = "SELECT COUNT(UID) AS VISITOR_COUNT FROM VISITOR_LOG ";
    $sql.= "WHERE WEEK(NOW()) = WEEK(LAST_LOGON) AND YEAR(NOW()) = YEAR(LAST_LOGON) ";
    $sql.= "AND FORUM = '$forum_fid'";

    if (!$result = db_query($sql, $db_stats_get_active_user_count)) return false;

    list($visitors_this_week) = db_fetch_array($result, DB_RESULT_NUM);

    $sql = "SELECT COUNT(UID) AS VISITOR_COUNT FROM VISITOR_LOG ";
    $sql.= "WHERE MONTH(NOW()) = MONTH(LAST_LOGON) AND YEAR(NOW()) = YEAR(LAST_LOGON) ";
    $sql.= "AND FORUM = '$forum_fid'";

    if (!$result = db_query($sql, $db_stats_get_active_user_count)) return false;

    list($visitors_this_month) = db_fetch_array($result, DB_RESULT_NUM);

    $sql = "SELECT COUNT(UID) AS VISITOR_COUNT FROM VISITOR_LOG ";
    $sql.= "WHERE YEAR(NOW()) = YEAR(LAST_LOGON) AND FORUM = '$forum_fid'";

    if (!$result = db_query($sql, $db_stats_get_active_user_count)) return false;

    list($visitors_this_year) = db_fetch_array($result, DB_RESULT_NUM);

    return array('DAY'   => $visitors_today,
                 'WEEK'  => $visitors_this_week,
                 'MONTH' => $visitors_this_month,
                 'YEAR'  => $visitors_this_year);
}

function stats_get_average_age()
{
    if (!$db_stats_get_average_age = db_connect()) return false;

    $sql = "SELECT AVG(DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(DOB, '%Y') - ";
    $sql.= "(DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(DOB, '00-%m-%d'))) AS AVERAGE_AGE ";
    $sql.= "FROM USER_PREFS WHERE DOB > 0";

    if (!$result = db_query($sql, $db_stats_get_average_age)) return false;

    list($average_age) = db_fetch_array($result, DB_RESULT_NUM);

    return $average_age;
}

function stats_get_most_popular_birthday()
{
    if (!$db_stats_get_most_popular_birthday = db_connect()) return false;

    $sql = "SELECT DAY(DOB) AS DOB_DAY, MONTH(DOB) AS DOB_MONTH, ";
    $sql.= "COUNT(*) AS DOB_COUNT FROM USER_PREFS WHERE DOB > 0 ";
    $sql.= "GROUP BY DOB ORDER BY DOB_COUNT DESC LIMIT 0, 1";

    if (!$result = db_query($sql, $db_stats_get_most_popular_birthday)) return false;

    $dob_data = db_fetch_array($result);

    return $dob_data;
}

function stats_get_users_without_profile_count()
{
    if (!$db_stats_get_users_without_profile_count = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT COUNT(USER.UID) AS USER_COUNT FROM USER ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PROFILE USER_PROFILE ";
    $sql.= "ON (USER_PROFILE.UID = USER.UID) ";
    $sql.= "WHERE USER_PROFILE.ENTRY IS NULL";

    if (!$result = db_query($sql, $db_stats_get_users_without_profile_count)) return false;

    list($user_count) = db_fetch_array($result, DB_RESULT_NUM);

    return $user_count;
}

function stats_get_users_with_profile_count()
{
    if (!$db_stats_get_users_with_profile_count = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT COUNT(DISTINCT UID) AS USER_COUNT FROM {$table_data['PREFIX']}USER_PROFILE";

    if (!$result = db_query($sql, $db_stats_get_users_with_profile_count)) return false;

    list($user_count) = db_fetch_array($result, DB_RESULT_NUM);

    return $user_count;
}

function stats_get_relationships_count()
{
    if (!$db_stats_get_relationships_count = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT COUNT(*) AS RELATIONSHIP_COUNT FROM {$table_data['PREFIX']}USER_PEER";

    if (!$result = db_query($sql, $db_stats_get_relationships_count)) return false;

    list($relationship_count) = db_fetch_array($result, DB_RESULT_NUM);

    return $relationship_count;
}

function stats_get_users_without_word_filter_count()
{
    if (!$db_stats_get_users_without_word_filter_count = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT COUNT(USER.UID) AS USER_COUNT FROM USER ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}WORD_FILTER WORD_FILTER ";
    $sql.= "ON (WORD_FILTER.UID = USER.UID) ";
    $sql.= "WHERE WORD_FILTER.MATCH_TEXT IS NULL";

    if (!$result = db_query($sql, $db_stats_get_users_without_word_filter_count)) return false;

    list($user_count) = db_fetch_array($result, DB_RESULT_NUM);

    return $user_count;
}

function stats_get_users_with_word_filter_count()
{
    if (!$db_stats_get_users_with_word_filter_count = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT COUNT(DISTINCT UID) AS USER_COUNT FROM {$table_data['PREFIX']}WORD_FILTER";

    if (!$result = db_query($sql, $db_stats_get_users_with_word_filter_count)) return false;

    list($user_count) = db_fetch_array($result, DB_RESULT_NUM);

    return $user_count;
}

?>