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

// We shouldn't be accessing this file directly.
if (basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "admin.inc.php");
include_once(BH_INCLUDE_PATH. "attachments.inc.php");
include_once(BH_INCLUDE_PATH. "cache.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "folder.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
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

    $sql = "SELECT ID FROM `{$table_data['PREFIX']}STATS` ";
    $sql.= "ORDER BY ID DESC LIMIT 0, 1";

    if (!$result = db_query($sql, $db_update_stats)) return false;

    $current_datetime = date(MYSQL_DATE_HOUR_MIN, time());

    if (db_num_rows($result) > 0) {

        $sql = "UPDATE LOW_PRIORITY `{$table_data['PREFIX']}STATS` SET ";
        $sql.= "MOST_USERS_DATE = CAST('$current_datetime' AS DATETIME), ";
        $sql.= "MOST_USERS_COUNT = '$session_count' WHERE MOST_USERS_COUNT < $session_count";

        if (!$result = db_query($sql, $db_update_stats)) return false;

        $sql = "UPDATE LOW_PRIORITY `{$table_data['PREFIX']}STATS` SET ";
        $sql.= "MOST_POSTS_DATE = CAST('$current_datetime' AS DATETIME), ";
        $sql.= "MOST_POSTS_COUNT = '$recent_post_count' WHERE MOST_POSTS_COUNT < $recent_post_count";

        if (!$result = db_query($sql, $db_update_stats)) return false;

    }else {

        $sql = "INSERT LOW_PRIORITY INTO `{$table_data['PREFIX']}STATS` ";
        $sql.= "(MOST_USERS_DATE, MOST_USERS_COUNT, MOST_POSTS_DATE, MOST_POSTS_COUNT) ";
        $sql.= "VALUES (CAST('$current_datetime' AS DATETIME), '$session_count', ";
        $sql.= "CAST('$current_datetime' AS DATETIME), '$recent_post_count')";

        if (!$result = db_query($sql, $db_update_stats)) return false;
    }

    return true;
}

function stats_get_html()
{
    // Check HTTP cache headers
    cache_check_last_modified(time() + 300);

    // Load Language file
    $lang = load_language_file();

    // Get webtag
    $webtag = get_webtag();

    // Current active user UID
    $uid = session_get_value('UID');

    // Number of active users
    $session_count = stats_get_active_session_count();

    // Number of recent posts.
    $recent_post_count = stats_get_recent_post_count();

    // Update the stats records.
    stats_update($session_count, $recent_post_count);

    // User Profile link
    $user_profile_link = '%s<a href="user_profile.php?webtag=%s&amp;uid=%s" target="_blank" class="popup 650x500"><span class="%s" title="%s">%s</span></a>';

    // Newest ser Profile link
    $new_user_profile_link = '<a href="user_profile.php?webtag=%s&amp;uid=%s" target="_blank" class="popup 650x500">%s</a>';

    // Search Engine Bot link
    $search_engine_bot_link = '<a href="%s" target="_blank"><span class="user_stats_normal">%s</span></a>';

    // Output the HTML.
    if (($user_stats = stats_get_active_user_list())) {

        $active_user_list_array = array();

        $html = "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" class=\"posthead\">\n";
        $html.= "  <tr>\n";
        $html.= "    <td width=\"35\">&nbsp;</td>\n";
        $html.= "    <td>&nbsp;</td>\n";
        $html.= "    <td width=\"35\">&nbsp;</td>\n";
        $html.= "  </tr>\n";
        $html.= "  <tr>\n";
        $html.= "    <td>&nbsp;</td>\n";
        $html.= "    <td>";

        if (forum_get_setting('guest_show_recent', 'Y') && user_guest_enabled()) {

            if ($user_stats['GUESTS'] <> 1) {
                $active_user_list_array[] = sprintf($lang['numactiveguests'], $user_stats['GUESTS']);
            }else {
                $active_user_list_array[] = $lang['oneactiveguest'];
            }
        }

        if ($user_stats['USER_COUNT'] <> 1) {
            $active_user_list_array[] = sprintf($lang['numactivemembers'], $user_stats['USER_COUNT']);
        }else {
            $active_user_list_array[] = $lang['oneactivemember'];
        }

        if ($user_stats['ANON_USERS'] <> 1) {
            $active_user_list_array[] = sprintf($lang['numactiveanonymousmembers'], $user_stats['ANON_USERS']);
        }else {
            $active_user_list_array[] = $lang['oneactiveanonymousmember'];
        }

        $active_user_list = implode(", ", $active_user_list_array);

        $active_user_time = format_time_display(forum_get_setting('active_sess_cutoff', false, 900), false);

        $html.= sprintf($lang['usersactiveinthepasttimeperiod'], $active_user_list, $active_user_time);

        $html.= " [ <a href=\"start.php?webtag=$webtag&amp;show=visitors\" target=\"". html_get_frame_name('main'). "\">{$lang['viewcompletelist']}</a> ]\n";
        $html.= "    </td>\n";
        $html.= "    <td width=\"35\">&nbsp;</td>\n";
        $html.= "  </tr>\n";

        if (sizeof($user_stats['USERS']) > 0) {

            $active_users_array = array();

            foreach ($user_stats['USERS'] as $user) {

                $active_user_title = '';

                $active_user_class = '';

                $active_user_avatar = '';

                if (isset($user['BOT_NAME']) && isset($user['BOT_URL'])) {

                    $active_user_display = word_filter_add_ob_tags($user['BOT_NAME'], true);
                    $active_user_display = sprintf($search_engine_bot_link, $user['BOT_URL'], $active_user_display);

                    $active_users_array[] = $active_user_display;

                }else {

                    $active_user_logon = format_user_name($user['LOGON'], $user['NICKNAME']);

                    $active_user_display = str_replace(" ", "&nbsp;", word_filter_add_ob_tags($active_user_logon, true));

                    if ($user['UID'] == $uid) {

                        if (isset($user['ANON_LOGON']) && $user['ANON_LOGON'] > 0) {

                            $active_user_title = $lang['youinvisible'];
                            $active_user_class = 'user_stats_curuser';

                        }else {

                            $active_user_title = $lang['younormal'];
                            $active_user_class = 'user_stats_curuser';
                        }

                    }elseif (($user['RELATIONSHIP'] & USER_FRIEND) > 0) {

                        $active_user_title = $lang['friend'];
                        $active_user_class = 'user_stats_friend';

                    }else {

                        $active_user_class = 'user_stats_normal';
                    }

                    if (isset($user['AVATAR_URL']) && strlen($user['AVATAR_URL']) > 0) {

                        $active_user_avatar = sprintf('<a href="user_profile.php?webtag=%s&amp;uid=%s" target="_blank" class="popup 650x500">
                                                         <img src="%s" title="%s" alt="" border="0" width="16" height="16" />
                                                       </a>', $webtag, $user['UID'], $user['AVATAR_URL'], htmlentities_array($active_user_title));

                    }else if (isset($user['AVATAR_AID']) && is_md5($user['AVATAR_AID'])) {

                        $attachment = attachments_get_by_hash($user['AVATAR_AID']);

                        if (!($user_avatar_picture = attachments_make_link($attachment, false, false, false, false))) {

                            $active_user_avatar = sprintf('<a href="user_profile.php?webtag=%s&amp;uid=%s" target="_blank" class="popup 650x500">
                                                             <img src="%s&amp;avatar_picture" title="%s" alt="" border="0" width="16" height="16" />
                                                           </a>', $webtag, $user['UID'], $user_avatar_picture, htmlentities_array($active_user_title));

                        }
                    }

                    $active_users_array[] = sprintf($user_profile_link, $active_user_avatar, $webtag, $user['UID'], $active_user_class, $active_user_title, $active_user_display);
                }
            }

            $html.= "  <tr>\n";
            $html.= "    <td width=\"35\">&nbsp;</td>\n";
            $html.= "    <td>&nbsp;</td>\n";
            $html.= "    <td width=\"35\">&nbsp;</td>\n";
            $html.= "  </tr>\n";
            $html.= "  <tr>";
            $html.= "    <td>&nbsp;</td>\n";
            $html.= "    <td class=\"activeusers\">\n";
            $html.= "      ". implode(", ", $active_users_array). "\n";
            $html.= "    </td>\n";
            $html.= "    <td width=\"35\">&nbsp;</td>\n";
            $html.= "  </tr>\n";
        }

        $html.= "  <tr>\n";
        $html.= "    <td width=\"35\">&nbsp;</td>\n";
        $html.= "    <td>&nbsp;</td>\n";
        $html.= "  </tr>\n";
        $html.= "</table>\n";
    }

    $thread_count = stats_get_thread_count();

    $post_count = stats_get_post_count();

    $html.= "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" class=\"posthead\">\n";
    $html.= "  <tr>\n";
    $html.= "    <td width=\"35\">&nbsp;</td>\n";
    $html.= "    <td>";

    if ($thread_count <> 1) {
        $num_threads_display = sprintf($lang['numthreadscreated'], number_format($thread_count, 0, ".", ","));
    }else {
        $num_threads_display = $lang['onethreadcreated'];
    }

    if ($post_count <> 1) {
        $num_posts_display = sprintf($lang['numpostscreated'], number_format($post_count, 0, ".", ","));
    }else {
        $num_posts_display = $lang['onepostcreated'];
    }

    $html.= sprintf($lang['ourmembershavemadeatotalofnumthreadsandnumposts'], $num_threads_display, $num_posts_display). '<br />';
    $html.= "    <td width=\"35\">&nbsp;</td>\n";
    $html.= "  </tr>\n";
    $html.= "</table>\n";

    if (($longest_thread = stats_get_longest_thread())) {

        $html.= "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" class=\"posthead\">\n";
        $html.= "  <tr>\n";
        $html.= "    <td width=\"35\">&nbsp;</td>\n";
        $html.= "    <td>";

        $longest_thread_title = word_filter_add_ob_tags($longest_thread['TITLE'], true);

        $longest_thread_link = sprintf("<a href=\"./index.php?webtag=$webtag&amp;msg=%d.1\">%s</a>", $longest_thread['TID'], $longest_thread_title);
        $longest_thread_post_count = ($longest_thread['LENGTH'] <> 1) ? sprintf($lang['numpostscreated'], $longest_thread['LENGTH']) : $lang['onepostcreated'];

        $html.= sprintf($lang['longestthreadisthreadnamewithnumposts'], $longest_thread_link, $longest_thread_post_count);

        $html.= "    </td>\n";
        $html.= "    <td width=\"35\">&nbsp;</td>\n";
        $html.= "  </tr>\n";
        $html.= "</table>\n";
    }

    $html.= "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" class=\"posthead\">\n";
    $html.= "  <tr>\n";
    $html.= "    <td width=\"35\">&nbsp;</td>\n";
    $html.= "    <td>&nbsp;</td>\n";
    $html.= "    <td width=\"35\">&nbsp;</td>\n";
    $html.= "  </tr>\n";
    $html.= "</table>\n";
    $html.= "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" class=\"posthead\">\n";
    $html.= "  <tr>\n";
    $html.= "    <td width=\"35\">&nbsp;</td>\n";
    $html.= "    <td>";

    if ($recent_post_count <> 1) {

        $recent_post_count = number_format($recent_post_count, 0, ",", ",");
        $html.= sprintf($lang['therehavebeenxpostsmadeinthelastsixtyminutes'], $recent_post_count);

    }else {

        $html.= $lang['therehasbeenonepostmadeinthelastsixtyminutes'];
    }

    $html.= "    </td>\n";
    $html.= "    <td width=\"35\">&nbsp;</td>\n";
    $html.= "  </tr>\n";
    $html.= "</table>\n";

    if (($most_posts = stats_get_most_posts())) {

        if (($most_posts['MOST_POSTS_COUNT'] > 0) && ($most_posts['MOST_POSTS_DATE'] > 0)) {

            $html.= "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" class=\"posthead\">\n";
            $html.= "  <tr>\n";
            $html.= "    <td width=\"35\">&nbsp;</td>\n";
            $html.= "    <td>";

            $post_stats_record_date = format_time($most_posts['MOST_POSTS_DATE']);

            $html.= sprintf($lang['mostpostsevermadeinasinglesixtyminuteperiodwasnumposts'], $most_posts['MOST_POSTS_COUNT'], $post_stats_record_date);

            $html.= "    </td>\n";
            $html.= "    <td width=\"35\">&nbsp;</td>\n";
            $html.= "  </tr>\n";
            $html.= "</table>\n";
        }
    }

    if (($user_count = user_count())) {

        $html.= "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" class=\"posthead\">\n";
        $html.= "  <tr>\n";
        $html.= "    <td width=\"35\">&nbsp;</td>\n";
        $html.= "    <td>&nbsp;</td>\n";
        $html.= "    <td width=\"35\">&nbsp;</td>\n";
        $html.= "  </tr>\n";
        $html.= "  <tr>\n";
        $html.= "    <td width=\"35\">&nbsp;</td>\n";
        $html.= "    <td>";

        if ($user_count <> 1) {

            if (($newest_member = stats_get_newest_user())) {

                $user_newest_display = word_filter_add_ob_tags(format_user_name($newest_member['LOGON'], $newest_member['NICKNAME']), true);
                $user_newest_profile_link = sprintf($new_user_profile_link, $webtag, $newest_member['UID'], $user_newest_display);

                $html.= sprintf($lang['wehavenumregisteredmembersandthenewestmemberismembername'], $user_count, $user_newest_profile_link);

            }else {

                $html.= sprintf($lang['wehavenumregisteredmember'], $user_count);

            }

        }else {

            $html.= $lang['wehaveoneregisteredmember'];
        }

        $html.= "    </td>\n";
        $html.= "    <td width=\"35\">&nbsp;</td>\n";
        $html.= "  </tr>\n";
        $html.= "</table>\n";
    }

    if (($most_users = stats_get_most_users())) {

        if (($most_users['MOST_USERS_COUNT'] > 0) && ($most_users['MOST_USERS_DATE'] > 0)) {

            $html.= "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" class=\"posthead\">\n";
            $html.= "  <tr>\n";
            $html.= "    <td width=\"35\">&nbsp;</td>\n";
            $html.= "    <td>";

            $most_users_count = number_format($most_users['MOST_USERS_COUNT'], 0, ",", ",");
            $most_users_date = format_time($most_users['MOST_USERS_DATE']);

            $html.= sprintf($lang['mostuserseveronlinewasnumondate'], $most_users_count, $most_users_date);

            $html.= "    </td>\n";
            $html.= "    <td width=\"35\">&nbsp;</td>\n";
            $html.= "  </tr>\n";
            $html.= "</table>\n";
        }
    }

    $html.= "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" class=\"posthead\">\n";
    $html.= "  <tr>\n";
    $html.= "    <td width=\"35\">&nbsp;</td>\n";
    $html.= "    <td>&nbsp;</td>\n";
    $html.= "    <td width=\"35\">&nbsp;</td>\n";
    $html.= "  </tr>\n";
    $html.= "</table>\n";
    $html.= "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" class=\"posthead\">\n";
    $html.= "  <tr>\n";
    $html.= "    <td width=\"35\">&nbsp;</td>\n";
    $html.= "    <td>&nbsp;</td>\n";
    $html.= "    <td width=\"35\">&nbsp;</td>\n";
    $html.= "  </tr>\n";
    $html.= "</table>\n";

    // Return the output buffer contents.
    return $html;
}

function stats_get_active_session_count()
{
    if (!$db_stats_get_active_session_count = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return 0;

    $forum_fid = $table_data['FID'];

    $active_sess_cutoff = intval(forum_get_setting('active_sess_cutoff', false, 900));

    $session_cutoff_datetime = date(MYSQL_DATETIME, time() - $active_sess_cutoff);

    $sql = "SELECT COUNT(UID) AS USER_COUNT FROM SESSIONS ";
    $sql.= "WHERE TIME >= CAST('$session_cutoff_datetime' AS DATETIME) ";
    $sql.= "AND FID = '$forum_fid'";

    if (!$result = db_query($sql, $db_stats_get_active_session_count)) return false;

    list($user_count) = db_fetch_array($result, DB_RESULT_NUM);

    return $user_count;
}

function stats_get_active_registered_user_count()
{
    if (!$db_stats_get_registered_user_count = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return 0;

    $forum_fid = $table_data['FID'];

    $active_sess_cutoff = intval(forum_get_setting('active_sess_cutoff', false, 900));

    $session_cutoff_datetime = date(MYSQL_DATETIME, time() - $active_sess_cutoff);

    $sql = "SELECT COUNT(UID) AS REGISTERED_USER_COUNT FROM SESSIONS ";
    $sql.= "WHERE TIME >= CAST('$session_cutoff_datetime' AS DATETIME) ";
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

    $active_sess_cutoff = intval(forum_get_setting('active_sess_cutoff', false, 900));

    $session_cutoff_datetime = date(MYSQL_DATETIME, time() - $active_sess_cutoff);

    $sql = "SELECT COUNT(UID) AS GUEST_COUNT FROM SESSIONS ";
    $sql.= "WHERE TIME >= CAST('$session_cutoff_datetime' AS DATETIME) ";
    $sql.= "AND FID = '$forum_fid' AND UID = 0";

    if (!$result = db_query($sql, $db_stats_get_active_guest_count)) return false;

    list($guest_count) = db_fetch_array($result, DB_RESULT_NUM);

    return $guest_count;
}

function stats_get_active_user_list()
{
    $stats = array('ANON_USERS' => 0, 'BOTS' => 0, 'GUESTS' => 0,
                   'USER_COUNT' => 0, 'USERS' => array());

    $user_sort = array();

    if (!$db_stats_get_active_user_list = db_connect()) return $stats;

    $lang = load_language_file();

    if (!$table_data = get_table_prefix()) return $stats;

    $forum_fid = $table_data['FID'];

    $active_sess_cutoff = intval(forum_get_setting('active_sess_cutoff', false, 900));

    $session_cutoff_datetime = date(MYSQL_DATETIME, time() - $active_sess_cutoff);

    if (($uid = session_get_value('UID')) === false) return $stats;

    // Current active number of guests
    $sql = "SELECT COUNT(UID) FROM SESSIONS WHERE UID = 0 AND SID = 0 ";
    $sql.= "AND SESSIONS.TIME >= CAST('$session_cutoff_datetime' AS DATETIME) ";
    $sql.= "AND SESSIONS.FID = '$forum_fid'";

    if (!$result = db_query($sql, $db_stats_get_active_user_list)) return $stats;

    list($stats['GUESTS']) = db_fetch_array($result, DB_RESULT_NUM);

    // Curent active users
    $sql = "SELECT DISTINCT SESSIONS.UID, USER.LOGON, USER.NICKNAME, USER_PEER2.PEER_NICKNAME, ";
    $sql.= "USER_PREFS_GLOBAL.ANON_LOGON AS ANON_LOGON_GLOBAL, USER_PREFS_FORUM.ANON_LOGON, ";
    $sql.= "USER_PEER.RELATIONSHIP AS PEER_RELATIONSHIP, USER_PEER2.RELATIONSHIP AS USER_RELATIONSHIP, ";
    $sql.= "SEARCH_ENGINE_BOTS.SID, SEARCH_ENGINE_BOTS.URL AS BOT_URL, SEARCH_ENGINE_BOTS.NAME AS BOT_NAME, ";
    $sql.= "USER_PREFS_FORUM.AVATAR_URL AS AVATAR_URL_FORUM, USER_PREFS_FORUM.AVATAR_AID AS AVATAR_AID_FORUM, ";
    $sql.= "USER_PREFS_GLOBAL.AVATAR_URL AS AVATAR_URL_GLOBAL, USER_PREFS_GLOBAL.AVATAR_AID AS AVATAR_AID_GLOBAL ";
    $sql.= "FROM SESSIONS SESSIONS LEFT JOIN USER USER ON (USER.UID = SESSIONS.UID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_PEER` USER_PEER ";
    $sql.= "ON (USER_PEER.UID = SESSIONS.UID AND USER_PEER.PEER_UID = '$uid') ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_PEER` USER_PEER2 ";
    $sql.= "ON (USER_PEER2.PEER_UID = SESSIONS.UID AND USER_PEER2.UID = '$uid') ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_PREFS` USER_PREFS_FORUM ON (USER_PREFS_FORUM.UID = SESSIONS.UID) ";
    $sql.= "LEFT JOIN USER_PREFS USER_PREFS_GLOBAL ON (USER_PREFS_GLOBAL.UID = SESSIONS.UID) ";
    $sql.= "LEFT JOIN SEARCH_ENGINE_BOTS ON (SEARCH_ENGINE_BOTS.SID = SESSIONS.SID) ";
    $sql.= "WHERE SESSIONS.TIME >= CAST('$session_cutoff_datetime' AS DATETIME) ";
    $sql.= "AND SESSIONS.FID = '$forum_fid' AND SESSIONS.UID > 0";

    if (!$result = db_query($sql, $db_stats_get_active_user_list)) return $stats;

    while (($user_data = db_fetch_array($result))) {

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

        if (isset($user_data['AVATAR_URL_FORUM']) && strlen($user_data['AVATAR_URL_FORUM']) > 0) {
            $user_data['AVATAR_URL'] = $user_data['AVATAR_URL_FORUM'];
        } else if (isset($user_data['AVATAR_URL_GLOBAL']) && strlen($user_data['AVATAR_URL_GLOBAL']) > 0) {
            $user_data['AVATAR_URL'] = $user_data['AVATAR_URL_GLOBAL'];
        } else {
            $user_data['AVATAR_URL'] = null;
        }

        if (isset($user_data['AVATAR_AID_FORUM']) && is_md5($user_data['AVATAR_AID_FORUM'])) {
            $user_data['AVATAR_AID'] = $user_data['AVATAR_AID_FORUM'];
        } else if (isset($user_data['AVATAR_AID_GLOBAL']) && is_md5($user_data['AVATAR_AID_GLOBAL'])) {
            $user_data['AVATAR_AID'] = $user_data['AVATAR_AID_GLOBAL'];
        } else {
            $user_data['AVATAR_AID'] = null;
        }

        if (!isset($user_data['LOGON'])) $user_data['LOGON'] = $lang['unknownuser'];
        if (!isset($user_data['NICKNAME'])) $user_data['NICKNAME'] = "";

        if (($user_data['USER_RELATIONSHIP'] & USER_IGNORED_COMPLETELY) > 0) {

            unset($user_data);

        }elseif (($anon_logon == USER_ANON_DISABLED) || ($user_data['UID'] == $uid) || (($user_data['PEER_RELATIONSHIP'] & USER_FRIEND) > 0 && $anon_logon == USER_ANON_FRIENDS_ONLY)) {

            if (isset($user_data['SID']) && !is_null($user_data['SID'])) {

                if (forum_get_setting('searchbots_show_active', 'Y')) {

                    $stats['BOTS']++;

                    $user_sort[] = $user_data['BOT_NAME'];

                    $stats['USERS'][] = array('BOT_NAME' => $user_data['BOT_NAME'],
                                              'BOT_URL'  => $user_data['BOT_URL']);

                }else {

                   $stats['GUESTS']++;
                }

            }else {

                $stats['USER_COUNT']++;

                $user_sort[] = format_user_name($user_data['LOGON'], $user_data['NICKNAME']);

                $stats['USERS'][] = array('UID'          => $user_data['UID'],
                                          'LOGON'        => $user_data['LOGON'],
                                          'NICKNAME'     => $user_data['NICKNAME'],
                                          'RELATIONSHIP' => $user_data['USER_RELATIONSHIP'],
                                          'ANON_LOGON'   => $anon_logon,
                                          'AVATAR_URL'   => $user_data['AVATAR_URL'],
                                          'AVATAR_AID'   => $user_data['AVATAR_AID']);
            }

        }else {

            $stats['ANON_USERS']++;
        }
    }

    $user_sort = array_map('strtolower', $user_sort);

    array_multisort($user_sort, SORT_ASC, SORT_STRING, $stats['USERS']);

    return $stats;
}

function stats_get_thread_count()
{
    if (!$db_stats_get_thread_count = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return 0;

    $sql = "SELECT COUNT(THREAD.TID) AS THREAD_COUNT ";
    $sql.= "FROM `{$table_data['PREFIX']}THREAD` THREAD";

    if (!$result = db_query($sql, $db_stats_get_thread_count)) return false;

    list($thread_count) = db_fetch_array($result, DB_RESULT_NUM);

    return $thread_count;
}

function stats_get_post_count()
{
    if (!$db_stats_get_post_count = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return 0;

    $sql = "SELECT COUNT(POST.PID) AS POST_COUNT FROM `{$table_data['PREFIX']}POST` POST";

    if (!$result = db_query($sql, $db_stats_get_post_count)) return false;

    list($post_count) = db_fetch_array($result, DB_RESULT_NUM);

    return $post_count;
}

function stats_get_recent_post_count()
{
    if (!$db_stats_get_recent_post_count = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return 0;

    $recent_post_datetime = date(MYSQL_DATETIME, time() - HOUR_IN_SECONDS);

    $sql = "SELECT COUNT(POST.PID) AS POSTS FROM `{$table_data['PREFIX']}POST` POST ";
    $sql.= "WHERE CREATED >= CAST('$recent_post_datetime' AS DATETIME)";

    if (!$result = db_query($sql, $db_stats_get_recent_post_count)) return false;

    list($post_count) = db_fetch_array($result, DB_RESULT_NUM);

    return $post_count;
}

function stats_get_longest_thread()
{
    if (!$db_stats_get_longest_thread = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    // Get the folders the user can see.
    $folders = folder_get_available();

    // Find the longest thread.
    $sql = "SELECT MAX(LENGTH) FROM `{$table_data['PREFIX']}THREAD` ";
    $sql.= "WHERE FID IN ($folders)";

    if (!$result = db_query($sql, $db_stats_get_longest_thread)) return false;

    list($highest_thread_count) = db_fetch_array($result, DB_RESULT_NUM);

    $sql = "SELECT THREAD.TID, THREAD.LENGTH, ";
    $sql.= "TRIM(CONCAT_WS(' ', COALESCE(FOLDER.PREFIX, ''), THREAD.TITLE)) AS TITLE ";
    $sql.= "FROM `{$table_data['PREFIX']}THREAD` THREAD LEFT JOIN `{$table_data['PREFIX']}FOLDER` FOLDER ";
    $sql.= "ON (FOLDER.FID = THREAD.FID) WHERE THREAD.LENGTH = '$highest_thread_count' ";
    $sql.= "AND THREAD.DELETED = 'N' LIMIT 0, 1";

    if (!$result = db_query($sql, $db_stats_get_longest_thread)) return false;

    if (db_num_rows($result) > 0) {

        $thread_data = db_fetch_array($result);
        return $thread_data;
    }

    return false;
}

function stats_get_user_count()
{
   if (!$db_stats_get_user_count = db_connect()) return false;

   $sql = "SELECT COUNT(UID) AS COUNT FROM USER";

   if (!$result = db_query($sql, $db_stats_get_user_count)) return false;

   list($user_count) = db_fetch_array($result, DB_RESULT_NUM);

   return $user_count;
}

function stats_get_most_users()
{
    if (!$db_stats_get_most_users = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT MOST_USERS_COUNT, UNIX_TIMESTAMP(MOST_USERS_DATE) AS MOST_USERS_DATE ";
    $sql.= "FROM `{$table_data['PREFIX']}STATS`";

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
    $sql.= "FROM `{$table_data['PREFIX']}STATS`";

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

    $lang = load_language_file();

    $uid = session_get_value('UID');

    $sql = "SELECT MAX(UID) FROM USER";

    if (!$result = db_query($sql, $db_stats_get_newest_user)) return false;

    list($newest_user_uid) = db_fetch_array($result, DB_RESULT_NUM);

    $sql = "SELECT USER.UID, USER.LOGON, USER.NICKNAME, USER_PEER.PEER_NICKNAME ";
    $sql.= "FROM USER LEFT JOIN `{$table_data['PREFIX']}USER_PEER` USER_PEER ";
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

function stats_get_post_tallys($start_timestamp, $end_timestamp)
{
    if (!$db_stats_get_post_tallys = db_connect()) return false;

    $lang = load_language_file();

    if (!is_numeric($start_timestamp)) return false;
    if (!is_numeric($end_timestamp)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $post_tallys = array('user_stats' => array(), 'post_count' => 0);

    $uid = session_get_value('UID');

    $post_start_datetime = date(MYSQL_DATETIME, $start_timestamp);
    $post_end_datetime = date(MYSQL_DATETIME, $end_timestamp);

    $sql = "SELECT COUNT(POST.PID) AS TOTAL_POST_COUNT ";
    $sql.= "FROM `{$table_data['PREFIX']}POST` POST ";
    $sql.= "WHERE POST.CREATED > CAST('$post_start_datetime' AS DATETIME) ";
    $sql.= "AND POST.CREATED < CAST('$post_end_datetime' AS DATETIME)";

    if (!$result = db_query($sql, $db_stats_get_post_tallys)) return false;

    list($post_tallys['post_count']) = db_fetch_array($result, DB_RESULT_NUM);

    $sql = "SELECT POST.FROM_UID AS UID, USER.LOGON, USER.NICKNAME, ";
    $sql.= "USER_PEER.PEER_NICKNAME, COUNT(POST.PID) AS POST_COUNT ";
    $sql.= "FROM `{$table_data['PREFIX']}POST` POST ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = POST.FROM_UID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_PEER` USER_PEER ";
    $sql.= "ON (USER_PEER.PEER_UID = USER.UID AND USER_PEER.UID = '$uid') ";
    $sql.= "WHERE POST.CREATED > CAST('$post_start_datetime' AS DATETIME) ";
    $sql.= "AND POST.CREATED < CAST('$post_end_datetime' AS DATETIME) ";
    $sql.= "GROUP BY POST.FROM_UID ORDER BY POST_COUNT DESC ";
    $sql.= "LIMIT 0, 20";

    if (!$result = db_query($sql, $db_stats_get_post_tallys)) return false;

    if (db_num_rows($result) > 0) {

        while (($user_stats = db_fetch_array($result))) {

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
    $sql.= "COUNT(POST.PID) AS POST_COUNT FROM `{$table_data['PREFIX']}POST` POST ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = POST.FROM_UID) ";
    $sql.= "GROUP BY POST.FROM_UID ORDER BY POST_COUNT DESC ";
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

    $sql = "SELECT COUNT(FID) AS FOLDER_COUNT FROM `{$table_data['PREFIX']}FOLDER`";

    if (!$result = db_query($sql, $db_stats_get_folder_count)) return false;

    list($folder_count) = db_fetch_array($result, DB_RESULT_NUM);

    return $folder_count;
}

function stats_get_folder_with_most_threads()
{
    if (!$db_stats_get_folder_with_most_threads = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT FOLDER.FID, FOLDER.TITLE, COUNT(THREAD.TID) AS THREAD_COUNT ";
    $sql.= "FROM `{$table_data['PREFIX']}THREAD` THREAD ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}FOLDER` FOLDER ON (FOLDER.FID = THREAD.FID) ";
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
    $sql.= "FROM `{$table_data['PREFIX']}FOLDER` FOLDER ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}THREAD` THREAD ON (THREAD.FID = FOLDER.FID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}POST` POST ON (POST.TID = THREAD.TID) ";
    $sql.= "GROUP BY FOLDER.FID ORDER BY POST_COUNT DESC ";
    $sql.= "LIMIT 0, 1";

    if (!$result = db_query($sql, $db_stats_get_folder_with_most_posts)) return false;

    if (db_num_rows($result) > 0) {

        $folder_data = db_fetch_array($result);

        return $folder_data;
    }

    return false;
}

function stats_get_most_read_thread()
{
    if (!$db_stats_get_most_read_threads = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT THREAD.TID, THREAD_STATS.VIEWCOUNT, ";
    $sql.= "TRIM(CONCAT_WS(' ', COALESCE(FOLDER.PREFIX, ''), THREAD.TITLE)) AS TITLE ";
    $sql.= "FROM `{$table_data['PREFIX']}THREAD_STATS` THREAD_STATS LEFT JOIN `{$table_data['PREFIX']}THREAD` THREAD ";
    $sql.= "ON (THREAD.TID = THREAD_STATS.TID) LEFT JOIN `{$table_data['PREFIX']}FOLDER` FOLDER ";
    $sql.= "ON (FOLDER.FID = THREAD.FID) ORDER BY THREAD_STATS.VIEWCOUNT DESC ";
    $sql.= "LIMIT 0, 1";

    if (!$result = db_query($sql, $db_stats_get_most_read_threads)) return false;

    if (db_num_rows($result) > 0) {
        return db_fetch_array($result);
    }

    return false;
}

function stats_get_thread_subscription_count()
{
    if (!$db_stats_get_thread_subscription_count = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT COUNT(TID) AS SUBSCRIPTION_COUNT FROM `{$table_data['PREFIX']}USER_THREAD` WHERE INTEREST = 2";

    if (!$result = db_query($sql, $db_stats_get_thread_subscription_count)) return false;

    list($subscription_count) = db_fetch_array($result, DB_RESULT_NUM);

    return $subscription_count;
}

function stats_get_most_subscribed_thread()
{
    if (!$db_stats_get_most_subscribed_threads = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT THREAD.TID, COUNT(USER_THREAD.INTEREST) AS SUBSCRIBERS, ";
    $sql.= "TRIM(CONCAT_WS(' ', COALESCE(FOLDER.PREFIX, ''), THREAD.TITLE)) AS TITLE ";
    $sql.= "FROM `{$table_data['PREFIX']}USER_THREAD` USER_THREAD ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}THREAD` THREAD ON (THREAD.TID = USER_THREAD.TID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}FOLDER` FOLDER ON (FOLDER.FID = THREAD.FID) ";
    $sql.= "WHERE USER_THREAD.INTEREST = 2 GROUP BY USER_THREAD.TID ";
    $sql.= "ORDER BY SUBSCRIBERS DESC LIMIT 0, 1";

    if (!$result = db_query($sql, $db_stats_get_most_subscribed_threads)) return false;

    if (db_num_rows($result) > 0) {
        return db_fetch_array($result);
    }

    return false;
}

function stats_get_poll_count()
{
    if (!$db_stats_get_poll_count = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT COUNT(TID) AS POLL_COUNT FROM `{$table_data['PREFIX']}POLL`";

    if (!$result = db_query($sql, $db_stats_get_poll_count)) return false;

    list($poll_count) = db_fetch_array($result, DB_RESULT_NUM);

    return $poll_count;
}

function stats_get_poll_option_count()
{
    if (!$db_stats_get_poll_option_count = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT COUNT(*) AS POLL_OPTION_COUNT FROM `{$table_data['PREFIX']}POLL_VOTES`";

    if (!$result = db_query($sql, $db_stats_get_poll_option_count)) return false;

    list($poll_option_count) = db_fetch_array($result, DB_RESULT_NUM);

    return $poll_option_count;
}

function stats_get_poll_vote_count()
{
    if (!$db_stats_get_poll_vote_count = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT COUNT(*) AS POLL_VOTE_COUNT FROM `{$table_data['PREFIX']}USER_POLL_VOTES`";

    if (!$result = db_query($sql, $db_stats_get_poll_vote_count)) return false;

    list($poll_vote_count) = db_fetch_array($result, DB_RESULT_NUM);

    return $poll_vote_count;
}

function stats_get_attachment_count()
{
    if (!$db_stats_get_attachment_count = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    $sql = "SELECT COUNT(*) AS ATTACHMENT_COUNT FROM POST_ATTACHMENT_IDS PAI ";
    $sql.= "LEFT JOIN POST_ATTACHMENT_FILES PAF ON (PAF.AID = PAI.AID) ";
    $sql.= "WHERE PAI.FID = '$forum_fid' AND PAF.FILENAME IS NOT NULL";

    if (!$result = db_query($sql, $db_stats_get_attachment_count)) return false;

    list($attachment_count) = db_fetch_array($result, DB_RESULT_NUM);

    return $attachment_count;
}

function stats_get_most_downloaded_attachment()
{
    if (!$db_stats_get_most_downloaded_attachment = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (!$attachment_dir = forum_get_setting('attachment_dir')) return false;

    $forum_fid = $table_data['FID'];

    $sql = "SELECT PAI.TID, PAI.PID, PAF.AID, PAF.HASH, PAF.FILENAME, ";
    $sql.= "PAF.MIMETYPE, PAF.DOWNLOADS FROM POST_ATTACHMENT_FILES PAF ";
    $sql.= "LEFT JOIN POST_ATTACHMENT_IDS PAI ON (PAI.AID = PAF.AID) ";
    $sql.= "WHERE PAI.FID = '$forum_fid' ";
    $sql.= "ORDER BY PAF.DOWNLOADS DESC ";

    if (!$result = db_unbuffered_query($sql, $db_stats_get_most_downloaded_attachment)) return false;

    while (($attachment_data = db_fetch_array($result))) {

        if (@file_exists("$attachment_dir/{$attachment_data['HASH']}")) {

            if (@file_exists("$attachment_dir/{$attachment_data['HASH']}.thumb")) {

                $filesize = filesize("$attachment_dir/{$attachment_data['HASH']}");
                $filesize+= filesize("$attachment_dir/{$attachment_data['HASH']}.thumb");

                return array("msg"       => sprintf("%s.%s", $attachment_data['TID'], $attachment_data['PID']),
                             "filename"  => rawurldecode($attachment_data['FILENAME']),
                             "filedate"  => filemtime("$attachment_dir/{$attachment_data['HASH']}"),
                             "filesize"  => $filesize,
                             "aid"       => $attachment_data['AID'],
                             "hash"      => $attachment_data['HASH'],
                             "mimetype"  => $attachment_data['MIMETYPE'],
                             "downloads" => $attachment_data['DOWNLOADS']);

            }else {

                return array("msg"       => sprintf("%s.%s", $attachment_data['TID'], $attachment_data['PID']),
                             "filename"  => rawurldecode($attachment_data['FILENAME']),
                             "filedate"  => filemtime("$attachment_dir/{$attachment_data['HASH']}"),
                             "filesize"  => filesize("$attachment_dir/{$attachment_data['HASH']}"),
                             "aid"       => $attachment_data['AID'],
                             "hash"      => $attachment_data['HASH'],
                             "mimetype"  => $attachment_data['MIMETYPE'],
                             "downloads" => $attachment_data['DOWNLOADS']);
            }
        }
    }

    return false;
}

function stats_get_most_popular_forum_style()
{
    if (!$db_stats_get_most_popular_forum_style = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT USER_PREFS.STYLE, USERS.USER_COUNT FROM `{$table_data['PREFIX']}USER_PREFS` USER_PREFS ";
    $sql.= "INNER JOIN (SELECT STYLE, COUNT(*) AS USER_COUNT FROM USER_PREFS GROUP BY STYLE LIMIT 1) AS USERS ";
    $sql.= "ON (USERS.STYLE = USER_PREFS.STYLE)";

    if (!$result = db_query($sql, $db_stats_get_most_popular_forum_style)) return false;

    if (db_num_rows($result) > 0) {

        $style_data = db_fetch_array($result);

        if (strlen(trim($style_data['STYLE'])) < 1) {
            $style_data['STYLE'] = forum_get_setting('default_style', false, 'default');
        }

        return $style_data;
    }

    return false;
}

function stats_get_most_popular_emoticon_pack()
{
    if (!$db_stats_get_most_popular_emoticon_pack = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT USER_PREFS.EMOTICONS, USERS.USER_COUNT FROM `{$table_data['PREFIX']}USER_PREFS` USER_PREFS ";
    $sql.= "INNER JOIN (SELECT EMOTICONS, COUNT(*) AS USER_COUNT FROM USER_PREFS GROUP BY EMOTICONS LIMIT 1) AS USERS ";
    $sql.= "ON (USERS.EMOTICONS = USER_PREFS.EMOTICONS)";

    if (!$result = db_query($sql, $db_stats_get_most_popular_emoticon_pack)) return false;

    if (db_num_rows($result) > 0) {

        $emoticon_data = db_fetch_array($result);

        if (strlen(trim($emoticon_data['EMOTICONS'])) < 1) {
            $emoticon_data['EMOTICONS'] = forum_get_setting('default_emoticons', false, 'default');
        }

        return $emoticon_data;
    }

    return false;
}

function stats_get_most_popular_language()
{
    if (!$db_stats_get_most_popular_language = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT USER_PREFS.LANGUAGE, USERS.USER_COUNT FROM `{$table_data['PREFIX']}USER_PREFS` USER_PREFS ";
    $sql.= "INNER JOIN (SELECT LANGUAGE, COUNT(*) AS USER_COUNT FROM USER_PREFS GROUP BY EMOTICONS LIMIT 1) AS USERS ";
    $sql.= "ON (USERS.LANGUAGE = USER_PREFS.LANGUAGE)";

    if (!$result = db_query($sql, $db_stats_get_most_popular_language)) return false;

    if (db_num_rows($result) > 0) {

        $language_data = db_fetch_array($result);

        if (strlen(trim($language_data['LANGUAGE'])) < 1) {
            $language_data['LANGUAGE'] = forum_get_setting('default_language', false, 'en');
        }

        return $language_data;
    }

    return false;
}

function stats_get_most_popular_timezone()
{
    if (!$db_stats_get_most_popular_timezone = db_connect()) return false;

    $sql = "SELECT TIMEZONE, COUNT(*) AS USER_COUNT FROM USER_PREFS ";
    $sql.= "GROUP BY TIMEZONE ORDER BY USER_COUNT DESC LIMIT 0,1";

    if (!$result = db_query($sql, $db_stats_get_most_popular_timezone)) return false;

    if (db_num_rows($result) > 0) {

        $timezone_data = db_fetch_array($result);
        return $timezone_data;
    }

    return false;
}

function stats_get_most_active_user()
{
    if (!$db_stats_get_most_active_user = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT USER.UID, USER.LOGON, USER.NICKNAME, ";
    $sql.= "UNIX_TIMESTAMP(USER_TRACK.USER_TIME_TOTAL) AS TOTAL_TIME ";
    $sql.= "FROM `{$table_data['PREFIX']}USER_TRACK` USER_TRACK ";
    $sql.= "LEFT JOIN USER ON (USER.UID = USER_TRACK.UID) ";
    $sql.= "WHERE USER_TRACK.USER_TIME_TOTAL IS NOT NULL ";
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
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}POST` POST ON (POST.FROM_UID = USER.UID) ";
    $sql.= "WHERE POST.TID IS NULL ";

    if (!$result = db_query($sql, $db_stats_get_inactive_user_count)) return false;

    list($user_count) = db_fetch_array($result, DB_RESULT_NUM);

    return $user_count;
}

function stats_get_active_user_count()
{
    if (!$db_stats_get_active_user_count = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT COUNT(DISTINCT FROM_UID) AS USER_COUNT FROM `{$table_data['PREFIX']}POST` ";

    if (!$result = db_query($sql, $db_stats_get_active_user_count)) return false;

    list($user_count) = db_fetch_array($result, DB_RESULT_NUM);

    return $user_count;
}

function stats_get_visitor_counts()
{
    if (!$db_stats_get_visitor_counts = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    // Year, Month, Week and Day
    list($year, $month, $week, $day) = explode('-', date('Y-m-w-d', time()));

    // Calculate the datetime for January 1st this year.
    $year_start_datetime = date(MYSQL_DATETIME_MIDNIGHT, mktime(0, 0, 0, 1, 1, $year));

    // Calculate the datetime for 1st of the month
    $month_start_datetime = date(MYSQL_DATETIME_MIDNIGHT, mktime(0, 0, 0, $month, 1, $year));

    // Calculate the timestamps for start of this week.
    $week_start_datetime = date(MYSQL_DATETIME_MIDNIGHT, mktime(0, 0, 0, $month, ($day - $week), $year));

    // Calculate the datetime for start of today.
    $day_start_datetime = date(MYSQL_DATETIME_MIDNIGHT, mktime(0, 0, 0, $month, $day, $year));

    // Get visitors for today.
    $sql = "SELECT COUNT(UID) AS VISITOR_COUNT FROM VISITOR_LOG ";
    $sql.= "WHERE LAST_LOGON >= CAST('$day_start_datetime' AS DATETIME) ";
    $sql.= "AND FORUM = '$forum_fid'";

    if (!$result = db_query($sql, $db_stats_get_visitor_counts)) return false;

    list($visitors_today) = db_fetch_array($result, DB_RESULT_NUM);

    $sql = "SELECT COUNT(UID) AS VISITOR_COUNT FROM VISITOR_LOG ";
    $sql.= "WHERE LAST_LOGON >= CAST('$week_start_datetime' AS DATETIME) ";
    $sql.= "AND FORUM = '$forum_fid'";

    if (!$result = db_query($sql, $db_stats_get_visitor_counts)) return false;

    list($visitors_this_week) = db_fetch_array($result, DB_RESULT_NUM);

    $sql = "SELECT COUNT(UID) AS VISITOR_COUNT FROM VISITOR_LOG ";
    $sql.= "WHERE LAST_LOGON >= CAST('$month_start_datetime' AS DATETIME) ";
    $sql.= "AND FORUM = '$forum_fid'";

    if (!$result = db_query($sql, $db_stats_get_visitor_counts)) return false;

    list($visitors_this_month) = db_fetch_array($result, DB_RESULT_NUM);

    $sql = "SELECT COUNT(UID) AS VISITOR_COUNT FROM VISITOR_LOG ";
    $sql.= "WHERE LAST_LOGON >= CAST('$year_start_datetime' AS DATETIME) ";
    $sql.= "AND FORUM = '$forum_fid'";

    if (!$result = db_query($sql, $db_stats_get_visitor_counts)) return false;

    list($visitors_this_year) = db_fetch_array($result, DB_RESULT_NUM);

    return array('DAY'   => $visitors_today,
                 'WEEK'  => $visitors_this_week,
                 'MONTH' => $visitors_this_month,
                 'YEAR'  => $visitors_this_year);
}

function stats_get_average_age()
{
    if (!$db_stats_get_average_age = db_connect()) return false;

    // Year, Month and Day
    list($year, $month, $day) = explode('-', date(MYSQL_DATE, time()));

    $sql = "SELECT AVG($year - DATE_FORMAT(DOB, '%Y') - ";
    $sql.= "(CAST('00-$month-$day' AS DATE) < DATE_FORMAT(DOB, '00-%m-%d'))) AS AVERAGE_AGE ";
    $sql.= "FROM USER_PREFS WHERE DOB > 0";

    if (!$result = db_query($sql, $db_stats_get_average_age)) return false;

    list($average_age) = db_fetch_array($result, DB_RESULT_NUM);

    return is_numeric($average_age) ? $average_age : false;
}

function stats_get_most_popular_birthday()
{
    if (!$db_stats_get_most_popular_birthday = db_connect()) return false;

    $sql = "SELECT DATE_FORMAT(DOB, '0000-%m-%d') AS DOB, ";
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
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_PROFILE` USER_PROFILE ";
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

    $sql = "SELECT COUNT(DISTINCT UID) AS USER_COUNT FROM `{$table_data['PREFIX']}USER_PROFILE`";

    if (!$result = db_query($sql, $db_stats_get_users_with_profile_count)) return false;

    list($user_count) = db_fetch_array($result, DB_RESULT_NUM);

    return $user_count;
}

function stats_get_users_without_signature_count()
{
    if (!$db_stats_get_users_without_profile_count = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT COUNT(USER.UID) AS USER_COUNT FROM USER ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_SIG` USER_SIG ON (USER_SIG.UID = USER.UID) ";
    $sql.= "WHERE USER_SIG.CONTENT IS NULL";

    if (!$result = db_query($sql, $db_stats_get_users_without_profile_count)) return false;

    list($user_count) = db_fetch_array($result, DB_RESULT_NUM);

    return $user_count;
}

function stats_get_users_with_signature_count()
{
    if (!$db_stats_get_users_with_profile_count = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT COUNT(DISTINCT UID) AS USER_COUNT FROM `{$table_data['PREFIX']}USER_SIG`";

    if (!$result = db_query($sql, $db_stats_get_users_with_profile_count)) return false;

    list($user_count) = db_fetch_array($result, DB_RESULT_NUM);

    return $user_count;
}

function stats_get_relationships_count()
{
    if (!$db_stats_get_relationships_count = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT COUNT(*) AS RELATIONSHIP_COUNT FROM `{$table_data['PREFIX']}USER_PEER`";

    if (!$result = db_query($sql, $db_stats_get_relationships_count)) return false;

    list($relationship_count) = db_fetch_array($result, DB_RESULT_NUM);

    return $relationship_count;
}

function stats_get_users_without_word_filter_count()
{
    if (!$db_stats_get_users_without_word_filter_count = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT COUNT(USER.UID) AS USER_COUNT FROM USER ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}WORD_FILTER` WORD_FILTER ON (WORD_FILTER.UID = USER.UID) ";
    $sql.= "WHERE WORD_FILTER.MATCH_TEXT IS NULL";

    if (!$result = db_query($sql, $db_stats_get_users_without_word_filter_count)) return false;

    list($user_count) = db_fetch_array($result, DB_RESULT_NUM);

    return $user_count;
}

function stats_get_users_with_word_filter_count()
{
    if (!$db_stats_get_users_with_word_filter_count = db_connect()) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "SELECT COUNT(DISTINCT UID) AS USER_COUNT ";
    $sql.= "FROM `{$table_data['PREFIX']}WORD_FILTER` ";
    $sql.= "WHERE UID > 0";

    if (!$result = db_query($sql, $db_stats_get_users_with_word_filter_count)) return false;

    list($user_count) = db_fetch_array($result, DB_RESULT_NUM);

    return $user_count;
}

function stats_get_mysql_week(&$week_start, &$week_end)
{
    if (!$stats_get_mysql_week = db_connect()) return false;

    $sql = "SELECT UNIX_TIMESTAMP(DATE_SUB(CURDATE(), INTERVAL(DAYOFWEEK(CURDATE()) - 1) DAY)) AS WEEK_START, ";
    $sql.= "UNIX_TIMESTAMP(DATE_ADD(CURDATE(), INTERVAL(7 - DAYOFWEEK(CURDATE())) DAY)) AS WEEK_END";

    if (!$result = db_query($sql, $stats_get_mysql_week)) return false;

    list($week_start, $week_end) = db_fetch_array($result, DB_RESULT_NUM);

    return true;
}

?>