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

require_once("./include/config.inc.php");

function update_stats()
{
    $db_update_stats = db_connect();

    $num_sessions = get_num_sessions();
    $num_recent_posts = get_recent_post_count();

    $sql = "SELECT * FROM ". forum_table("STATS");
    $result = db_query($sql, $db_update_stats);

    if (db_num_rows($result)) {

        $stats_array = db_fetch_array($result);

        if ($num_sessions > $stats_array['MOST_USERS_COUNT']) {

            $sql = "UPDATE ". forum_table("STATS"). " SET ";
            $sql.= "MOST_USERS_DATE = NOW(), MOST_USERS_COUNT = $num_sessions";

            $result = db_query($sql, $db_update_stats);
        }

        if ($num_recent_posts > $stats_array['MOST_POSTS_COUNT']) {

            $sql = "UPDATE ". forum_table("STATS"). " SET ";
            $sql.= "MOST_POSTS_DATE = NOW(), MOST_POSTS_COUNT = $num_recent_posts";

            $result = db_query($sql, $db_update_stats);
        }

    }else {

        $sql = "INSERT INTO ". forum_table("STATS"). " (MOST_USERS_DATE, ";
        $sql.= "MOST_USERS_COUNT, MOST_POSTS_DATE, MOST_POSTS_COUNT) ";
        $sql.= "VALUES (NOW(), '$num_sessions', NOW(), '$num_recent_posts')";

        $result = db_query($sql, $db_update_stats);

    }
}

function get_num_sessions()
{
    global $session_cutoff;

    $get_num_sessions = db_connect();
    $session_stamp = time() - $session_cutoff;

    $sql = "SELECT COUNT(UID) AS SESSION_COUNT FROM ". forum_table("SESSIONS"). " ";
    $sql.= "WHERE TIME >= FROM_UNIXTIME($session_stamp) ";

    $result = db_query($sql, $get_num_sessions);

    if (db_num_rows($result)) {
        $row = db_fetch_array($result);
        return $row['SESSION_COUNT'];
    }

    return 0;
}

function get_active_users()
{
    global $session_cutoff;

    $db_get_active_users = db_connect();
    $session_stamp = time() - $session_cutoff;

    $uid = bh_session_get_value('UID');

    $stats = array('GUESTS' => 0, 'NUSERS' => 0,
                   'AUSERS' => 0, 'USERS'  => array());

    // Current active users

    $sql = "SELECT SESSIONS.UID, SESSIONS.TIME, USER.LOGON, USER.NICKNAME, ";
    $sql.= "USER_PREFS.ANON_LOGON FROM ". forum_table("SESSIONS"). " SESSIONS ";
    $sql.= "LEFT JOIN ". forum_table("USER"). " USER ON (USER.UID = SESSIONS.UID) ";
    $sql.= "LEFT JOIN ". forum_table("USER_PREFS"). " USER_PREFS ON (USER_PREFS.UID = SESSIONS.UID) ";
    $sql.= "WHERE SESSIONS.TIME >= FROM_UNIXTIME($session_stamp) ";
    $sql.= "ORDER BY SESSIONS.TIME DESC";

    $result = db_query($sql, $db_get_active_users);

    while ($row = db_fetch_array($result)) {

        if ($row['UID'] == 0) {

            $stats['GUESTS']++;

        }elseif (isset($row['ANON_LOGON']) && $row['ANON_LOGON'] == 1) {

            $stats['AUSERS']++;

        }else {

            $stats['NUSERS']++;
            $stats['USERS'][] = array('UID'      => $row['UID'],
                                      'LOGON'    => $row['LOGON'],
                                      'NICKNAME' => $row['NICKNAME']);
        }
    }

    return $stats;
}

function get_thread_count()
{
    $db_get_thread_count = db_connect();

    $sql = "SELECT COUNT(THREAD.TID) AS THREADS FROM ". forum_table("THREAD");
    $result = db_query($sql, $db_get_thread_count);

    if (db_num_rows($result)) {
        $row = db_fetch_array($result);
        return $row['THREADS'];
    }

    return 0;
}

function get_post_count()
{
    $db_get_post_count = db_connect();

    $sql = "SELECT COUNT(POST.PID) AS POSTS FROM ". forum_table("POST");
    $result = db_query($sql, $db_get_post_count);

    if (db_num_rows($result)) {
        $row = db_fetch_array($result);
        return $row['POSTS'];
    }

    return 0;
}

function get_recent_post_count()
{
    $db_get_post_count = db_connect();

    $post_stamp = time() - HOUR_IN_SECONDS;

    $sql = "SELECT COUNT(POST.PID) AS POSTS FROM ". forum_table("POST"). " ";
    $sql.= "WHERE CREATED >= FROM_UNIXTIME($post_stamp)";

    $result = db_query($sql, $db_get_post_count);

    if (db_num_rows($result)) {
        $row = db_fetch_array($result);
        return $row['POSTS'];
    }

    return 0;
}

function get_longest_thread()
{
    $db_get_longest_thread = db_connect();

    $sql = "SELECT THREAD.TITLE, THREAD.TID, THREAD.LENGTH FROM ". forum_table("THREAD"). " ";
    $sql.= "ORDER BY THREAD.LENGTH DESC LIMIT 0, 1";

    $result = db_query($sql, $db_get_longest_thread);

    if (db_num_rows($result)) {
        $row = db_fetch_array($result);
        return $row;
    }

    return false;
}

function get_most_users()
{
    $db_get_most_users = db_connect();

    $sql = "SELECT MOST_USERS_COUNT, UNIX_TIMESTAMP(MOST_USERS_DATE) AS MOST_USERS_DATE ";
    $sql.= "FROM ". forum_table("STATS");

    $result = db_query($sql, $db_get_most_users);

    if (db_num_rows($result)) {
        $row = db_fetch_array($result);
        return $row;
    }

    return false;
}

function get_most_posts()
{
    $db_get_most_posts = db_connect();

    $sql = "SELECT MOST_POSTS_COUNT, UNIX_TIMESTAMP(MOST_POSTS_DATE) AS MOST_POSTS_DATE ";
    $sql.= "FROM ". forum_table("STATS");

    $result = db_query($sql, $db_get_most_posts);

    if (db_num_rows($result)) {
        $row = db_fetch_array($result);
        return $row;
    }

    return false;
}

function get_newest_user()
{
    $db_get_newest_user = db_connect();

    $sql = "SELECT UID, LOGON, NICKNAME FROM USER WHERE ";
    $sql.= "LOGON <> 'GUEST' AND PASSWD <> MD5('GUEST') ";
    $sql.= "ORDER BY UID DESC LIMIT 0, 1";

    $result = db_query($sql, $db_get_newest_user);

    if (db_num_rows($result)) {
        $row = db_fetch_array($result);
        return $row;
    }

    return false;
}

?>