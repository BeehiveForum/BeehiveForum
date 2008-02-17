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

/* $Id: stats.inc.php,v 1.93 2008-02-17 09:58:29 decoyduck Exp $ */

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
include_once(BH_INCLUDE_PATH. "user.inc.php");
include_once(BH_INCLUDE_PATH. "word_filter.inc.php");

function update_stats()
{
    if (!$db_update_stats = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $num_sessions = get_num_sessions();
    $num_recent_posts = get_recent_post_count();

    $sql = "SELECT ID FROM {$table_data['PREFIX']}STATS ";
    $sql.= "ORDER BY ID DESC LIMIT 0, 1";

    if (!$result = db_query($sql, $db_update_stats)) return false;

    if (db_num_rows($result) > 0) {

        $sql = "UPDATE LOW_PRIORITY {$table_data['PREFIX']}STATS SET ";
        $sql.= "MOST_USERS_DATE = NOW(), MOST_USERS_COUNT = '$num_sessions' ";
        $sql.= "WHERE MOST_USERS_COUNT < $num_sessions";

        if (!$result = db_query($sql, $db_update_stats)) return false;

        $sql = "UPDATE LOW_PRIORITY {$table_data['PREFIX']}STATS SET ";
        $sql.= "MOST_POSTS_DATE = NOW(), MOST_POSTS_COUNT = '$num_recent_posts' ";
        $sql.= "WHERE MOST_POSTS_COUNT < $num_recent_posts";

        if (!$result = db_query($sql, $db_update_stats)) return false;

    }else {

        $sql = "INSERT LOW_PRIORITY INTO {$table_data['PREFIX']}STATS (MOST_USERS_DATE, ";
        $sql.= "MOST_USERS_COUNT, MOST_POSTS_DATE, MOST_POSTS_COUNT) ";
        $sql.= "VALUES (NOW(), '$num_sessions', NOW(), '$num_recent_posts')";

        if (!$result = db_query($sql, $db_update_stats)) return false;
    }

    admin_add_log_entry(FORUM_AUTO_UPDATE_STATS);

    return true;
}

function stats_output_xml()
{
    // Outputting XML

    header('Content-Type: text/xml', true);

    // Check HTTP cache headers

    header_check_cache();

    // Output the XML document.

    echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
    echo "<stats>\n";
    echo "  <users>\n";

    if ($user_count = user_count()) {
        echo sprintf("    <count>%s</count>\n", html_entity_to_decimal(number_format($user_count, 0, ",", ",")));
    }

    if ($user_stats = get_active_users()) {

        echo "    <active>\n";
        echo "      <guests>", html_entity_to_decimal($user_stats['GUESTS']), "</guests>\n";
        echo "      <visible>", html_entity_to_decimal($user_stats['NUSERS']), "</visible>\n";
        echo "      <anonymous>", html_entity_to_decimal($user_stats['AUSERS']), "</anonymous>\n";

        if (isset($user_stats['USERS']) && sizeof($user_stats['USERS']) > 0) {

            echo "    <list>\n";

            foreach ($user_stats['USERS'] as $active_user) {

                $active_user['DISPLAY'] = word_filter_add_ob_tags(_htmlentities(format_user_name($active_user['LOGON'], $active_user['NICKNAME'])));

                echo "      <user>\n";
                echo "        <uid>", html_entity_to_decimal($active_user['UID']), "</uid>\n";
                echo "        <display>", html_entity_to_decimal($active_user['DISPLAY']), "</display>\n";
                echo "        <relationship>", html_entity_to_decimal($active_user['RELATIONSHIP']), "</relationship>\n";
                echo "        <anonymous>", html_entity_to_decimal($active_user['ANON_LOGON']), "</anonymous>\n";
                echo "      </user>\n";
            }

            echo "    </list>\n";
        }

        echo "    </active>\n";
    }

    if ($newest_user = get_newest_user()) {

        $newest_user['DISPLAY'] = word_filter_add_ob_tags(_htmlentities(format_user_name($newest_user['LOGON'], $newest_user['NICKNAME'])));

        echo "    <newest>\n";
        echo "      <uid>", html_entity_to_decimal($newest_user['UID']), "</uid>\n";
        echo "      <display>", html_entity_to_decimal($newest_user['DISPLAY']), "</display>\n";
        echo "    </newest>\n";
    }

    if ($most_users = get_most_users()) {

        $most_users_count = number_format($most_users['MOST_USERS_COUNT'], 0, ",", ",");
        $most_users_date =  format_time($most_users['MOST_USERS_DATE'], 1);

        echo "    <record>\n";
        echo "      <count>", html_entity_to_decimal($most_users_count), "</count>\n";
        echo "      <date>", html_entity_to_decimal($most_users_date), "</date>\n";
        echo "    </record>\n";
    }

    echo "  </users>\n";
    echo "  <threads>\n";

    if ($thread_count = get_thread_count()) {
        echo sprintf("    <count>%s</count>\n", html_entity_to_decimal(number_format($thread_count, 0, ",", ",")));
    }

    if ($longest_thread = get_longest_thread()) {

        $longest_thread_title = word_filter_add_ob_tags(_htmlentities(thread_format_prefix($longest_thread['PREFIX'], $longest_thread['TITLE'])));
        $longest_thread_post_count = number_format($longest_thread['LENGTH'], 0, ",", ",");

        echo "    <longest>\n";
        echo "      <tid>", html_entity_to_decimal($longest_thread['TID']), "</tid>\n";
        echo "      <title>", html_entity_to_decimal($longest_thread_title), "</title>\n";
        echo "      <length>", html_entity_to_decimal($longest_thread_post_count), "</length>\n";
        echo "    </longest>\n";
    }

    echo "  </threads>\n";
    echo "  <posts>\n";

    if ($post_count = get_post_count()) {
        echo sprintf("    <count>%s</count>\n", html_entity_to_decimal(number_format($post_count, 0, ",", ",")));
    }

    $recent_post_count = get_recent_post_count();

    $recent_post_count = number_format($recent_post_count, 0, ",", ",");

    echo "    <recent>\n";
    echo sprintf("    <count>%s</count>\n", number_format($recent_post_count, 0, ",", ","));

    if ($most_posts = get_most_posts()) {

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

function get_num_sessions()
{
    if (!$get_num_sessions = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return 0;

    $forum_fid = $table_data['FID'];

    $sessions_array = array();

    $session_stamp = time() - intval(forum_get_setting('active_sess_cutoff', false, 900));

    $sql = "SELECT COUNT(UID) AS USER_COUNT FROM SESSIONS ";
    $sql.= "WHERE TIME >= FROM_UNIXTIME($session_stamp) ";
    $sql.= "AND FID = '$forum_fid'";

    if (!$result = db_query($sql, $get_num_sessions)) return false;

    if (db_num_rows($result) > 0) {

        list($user_count) = db_fetch_array($result, DB_RESULT_NUM);
        return $user_count;
    }

    return 0;
}

function get_active_users()
{
    if (!$db_get_active_users = db_connect()) return false;

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

    if (!$result = db_query($sql, $db_get_active_users)) return false;

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

    if (!$result = db_query($sql, $db_get_active_users)) return false;

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

function get_thread_count()
{
    if (!$db_get_thread_count = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return 0;

    $sql = "SELECT COUNT(THREAD.TID) AS THREAD_COUNT ";
    $sql.= "FROM {$table_data['PREFIX']}THREAD THREAD";

    if (!$result = db_query($sql, $db_get_thread_count)) return false;

    if (db_num_rows($result) > 0) {

        list($thread_count) = db_fetch_array($result, DB_RESULT_NUM);
        return $thread_count;
    }

    return 0;
}

function get_post_count()
{
    if (!$db_get_post_count = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return 0;

    $sql = "SELECT COUNT(POST.PID) AS POST_COUNT FROM {$table_data['PREFIX']}POST POST";

    if (!$result = db_query($sql, $db_get_post_count)) return false;

    if (db_num_rows($result) > 0) {

        list($post_count) = db_fetch_array($result, DB_RESULT_NUM);
        return $post_count;
    }

    return 0;
}

function get_recent_post_count()
{
    if (!$db_get_post_count = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return 0;

    $post_stamp = time() - HOUR_IN_SECONDS;

    $sql = "SELECT COUNT(POST.PID) AS POSTS FROM {$table_data['PREFIX']}POST POST ";
    $sql.= "WHERE CREATED >= FROM_UNIXTIME($post_stamp)";

    if (!$result = db_query($sql, $db_get_post_count)) return false;

    if (db_num_rows($result) > 0) {

        list($post_count) = db_fetch_array($result, DB_RESULT_NUM);
        return $post_count;
    }

    return 0;
}

function get_longest_thread()
{
    if (!$db_get_longest_thread = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    // Get the folders the user can see.

    $folders = folder_get_available();

    // Find the longest thread.

    $sql = "SELECT MAX(LENGTH) FROM {$table_data['PREFIX']}THREAD ";
    $sql.= "WHERE FID IN ($folders)";

    if (!$result = db_query($sql, $db_get_longest_thread)) return false;

    list($highest_thread_count) = db_fetch_array($result, DB_RESULT_NUM);

    $sql = "SELECT THREAD.TITLE, THREAD.TID, THREAD.LENGTH, FOLDER.PREFIX ";
    $sql.= "FROM {$table_data['PREFIX']}THREAD THREAD ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}FOLDER FOLDER ";
    $sql.= "ON (FOLDER.FID = THREAD.FID) ";
    $sql.= "WHERE THREAD.LENGTH = '$highest_thread_count'";
    $sql.= "LIMIT 0, 1";

    if (!$result = db_query($sql, $db_get_longest_thread)) return false;

    if (db_num_rows($result) > 0) {

        $thread_data = db_fetch_array($result);
        return $thread_data;
    }

    return false;
}

function get_most_users()
{
    if (!$db_get_most_users = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT MOST_USERS_COUNT, UNIX_TIMESTAMP(MOST_USERS_DATE) AS MOST_USERS_DATE ";
    $sql.= "FROM {$table_data['PREFIX']}STATS";

    if (!$result = db_query($sql, $db_get_most_users)) return false;

    if (db_num_rows($result) > 0) {

        $user_data = db_fetch_array($result);
        return $user_data;
    }

    return false;
}

function get_most_posts()
{
    if (!$db_get_most_posts = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT MOST_POSTS_COUNT, UNIX_TIMESTAMP(MOST_POSTS_DATE) AS MOST_POSTS_DATE ";
    $sql.= "FROM {$table_data['PREFIX']}STATS";

    if (!$result = db_query($sql, $db_get_most_posts)) return false;

    if (db_num_rows($result) > 0) {

        $post_data = db_fetch_array($result);
        return $post_data;
    }

    return false;
}

function get_newest_user()
{
    if (!$db_get_newest_user = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $uid = bh_session_get_value('UID');

    $sql = "SELECT MAX(UID) FROM USER";

    if (!$result = db_query($sql, $db_get_newest_user)) return false;

    list($newest_user_uid) = db_fetch_array($result, DB_RESULT_NUM);

    $sql = "SELECT USER.UID, USER.LOGON, USER.NICKNAME, USER_PEER.PEER_NICKNAME ";
    $sql.= "FROM USER LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER ";
    $sql.= "ON (USER_PEER.PEER_UID = USER.UID AND USER_PEER.UID = '$uid') ";
    $sql.= "WHERE USER.UID = '$newest_user_uid'";

    if (!$result = db_query($sql, $db_get_newest_user)) return false;

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

function get_post_tallys($start_stamp, $end_stamp)
{
    if (!$db_get_month_post_tallys = db_connect()) return false;

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

    if (!$result = db_query($sql, $db_get_month_post_tallys)) return false;

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

    if (!$result = db_query($sql, $db_get_month_post_tallys)) return false;

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

?>