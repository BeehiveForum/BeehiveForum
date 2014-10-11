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
require_once BH_INCLUDE_PATH . 'attachments.inc.php';
require_once BH_INCLUDE_PATH . 'constants.inc.php';
require_once BH_INCLUDE_PATH . 'db.inc.php';
require_once BH_INCLUDE_PATH . 'folder.inc.php';
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'forum.inc.php';
require_once BH_INCLUDE_PATH . 'html.inc.php';
require_once BH_INCLUDE_PATH . 'user.inc.php';
require_once BH_INCLUDE_PATH . 'word_filter.inc.php';
// End Required includes

/**
 * @param $session_count
 * @param $recent_post_count
 * @return bool
 */
function stats_update($session_count, $recent_post_count)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($session_count)) return false;
    if (!is_numeric($recent_post_count)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT ID FROM `{$table_prefix}STATS` ";
    $sql .= "ORDER BY ID DESC LIMIT 0, 1";

    if (!($result = $db->query($sql))) return false;

    $current_datetime = date(MYSQL_DATE_HOUR_MIN, time());

    if ($result->num_rows > 0) {

        $sql = "UPDATE LOW_PRIORITY `{$table_prefix}STATS` SET ";
        $sql .= "MOST_USERS_DATE = CAST('$current_datetime' AS DATETIME), ";
        $sql .= "MOST_USERS_COUNT = '$session_count' WHERE MOST_USERS_COUNT < $session_count";

        if (!($result = $db->query($sql))) return false;

        $sql = "UPDATE LOW_PRIORITY `{$table_prefix}STATS` SET ";
        $sql .= "MOST_POSTS_DATE = CAST('$current_datetime' AS DATETIME), ";
        $sql .= "MOST_POSTS_COUNT = '$recent_post_count' WHERE MOST_POSTS_COUNT < $recent_post_count";

        if (!($result = $db->query($sql))) return false;

    } else {

        $sql = "INSERT LOW_PRIORITY INTO `{$table_prefix}STATS` ";
        $sql .= "(MOST_USERS_DATE, MOST_USERS_COUNT, MOST_POSTS_DATE, MOST_POSTS_COUNT) ";
        $sql .= "VALUES (CAST('$current_datetime' AS DATETIME), '$session_count', ";
        $sql .= "CAST('$current_datetime' AS DATETIME), '$recent_post_count')";

        if (!($result = $db->query($sql))) return false;
    }

    return true;
}

/**
 * @return string
 */
function stats_get_html()
{
    // Get webtag
    $webtag = get_webtag();

    // Validate the webtag
    forum_check_webtag_available($webtag);

    // Number of active users
    $session_count = stats_get_active_session_count();

    // Number of recent posts.
    $recent_post_count = stats_get_recent_post_count();

    // Update the stats records.
    stats_update($session_count, $recent_post_count);

    // User Profile link
    $user_profile_link = '%s&nbsp;<a href="user_profile.php?webtag=%s&amp;uid=%s" target="_blank" class="popup 650x500"><span class="%s" title="%s">%s</span></a>';

    // Newest user Profile link
    $new_user_profile_link = '<a href="user_profile.php?webtag=%s&amp;uid=%s" target="_blank" class="popup 650x500">%s</a>';

    // Search Engine Bot link
    $search_engine_bot_link = '<a href="%s" target="_blank"><span class="user_stats_normal">%s</span></a>';

    $html = "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" class=\"posthead\">\n";
    $html .= "  <tr>\n";
    $html .= "    <td rowspan=\"19\" width=\"35\">&nbsp;</td>\n";
    $html .= "    <td>&nbsp;</td>\n";
    $html .= "    <td rowspan=\"19\" width=\"35\">&nbsp;</td>\n";
    $html .= "  </tr>\n";

    // Output the HTML.
    if (($user_stats = stats_get_active_user_list()) !== false) {

        $user_list_array = array();

        $html .= "  <tr>\n";
        $html .= "    <td>";

        if (forum_get_setting('guest_show_recent', 'Y') && user_guest_enabled()) {

            if ($user_stats['GUESTS'] <> 1) {
                $user_list_array[] = sprintf(gettext("<b>%s</b> guests"), format_number($user_stats['GUESTS']));
            } else {
                $user_list_array[] = gettext("<b>1</b> guest");
            }
        }

        if ($user_stats['USER_COUNT'] <> 1) {
            $user_list_array[] = sprintf(gettext("<b>%s</b> members"), format_number($user_stats['USER_COUNT']));
        } else {
            $user_list_array[] = gettext("<b>1</b> member");
        }

        if ($user_stats['ANON_USERS'] <> 1) {
            $user_list_array[] = sprintf(gettext("<b>%s</b> anonymous members"), format_number($user_stats['ANON_USERS']));
        } else {
            $user_list_array[] = gettext("<b>1</b> anonymous member");
        }

        $user_list = implode(", ", $user_list_array);

        $user_time = format_time_display(ini_get('session.gc_maxlifetime'), false);

        $html .= sprintf(gettext("%s active in the past %s."), $user_list, $user_time);

        $html .= " <a href=\"visitor_log.php?webtag=$webtag&amp;show=visitors\" target=\"_self"\">" . gettext("View More Visitors") . "</a>\n";
        $html .= "    </td>\n";
        $html .= "  </tr>\n";

        if (sizeof($user_stats['USERS']) > 0) {

            $users_array = array();

            foreach ($user_stats['USERS'] as $user) {

                $user_avatar = '';

                if (isset($user['BOT_NAME']) && isset($user['BOT_URL'])) {

                    $user_display = word_filter_add_ob_tags($user['BOT_NAME'], true);
                    $user_display = sprintf($search_engine_bot_link, $user['BOT_URL'], $user_display);

                    $users_array[] = $user_display;

                } else {

                    $user_logon = format_user_name($user['LOGON'], $user['NICKNAME']);

                    $user_display = str_replace(" ", "&nbsp;", word_filter_add_ob_tags($user_logon, true));

                    if ($user['UID'] == $_SESSION['UID']) {

                        if (isset($user['ANON_LOGON']) && $user['ANON_LOGON'] > USER_ANON_DISABLED) {

                            $user_title = gettext("You (Invisible)");
                            $user_class = 'user_stats_curuser';

                        } else {

                            $user_title = gettext("You");
                            $user_class = 'user_stats_curuser';
                        }

                    } else if (($user['RELATIONSHIP'] & USER_FRIEND) > 0) {

                        $user_title = gettext("Friend");
                        $user_class = 'user_stats_friend';

                    } else {

                        $user_class = 'user_stats_normal';
                        $user_title = '';
                    }

                    if (isset($user['AVATAR_URL']) && strlen($user['AVATAR_URL']) > 0) {

                        $user_avatar = html_style_image(
                            'profile_image profile_image_small',
                            htmlentities_array($user_title),
                            null,
                            array(
                                'background-image' => sprintf(
                                    "url('%s')",
                                    $user['AVATAR_URL']
                                )
                            )
                        );

                    } else if (isset($user['AVATAR_AID']) && is_numeric($user['AVATAR_AID'])) {

                        $attachment = attachments_get_by_aid($user['AVATAR_AID']);

                        if (($user_avatar_picture = attachments_make_link($attachment, false, false, false, false)) !== false) {

                            $user_avatar = html_style_image(
                                'profile_image profile_image_small',
                                htmlentities_array($user_title),
                                null,
                                array(
                                    'background-image' => sprintf(
                                        "url('%s&amp;profile_picture')",
                                        $user_avatar_picture
                                    )
                                )
                            );
                        }
                    }

                    $users_array[] = sprintf($user_profile_link, $user_avatar, $webtag, $user['UID'], $user_class, $user_title, $user_display);
                }
            }

            $html .= "  <tr>";
            $html .= "    <td class=\"activeusers\">\n";
            $html .= "      " . implode(", ", $users_array) . "\n";
            $html .= "    </td>\n";
            $html .= "  </tr>\n";
        }

        $html .= "  <tr>\n";
        $html .= "    <td>&nbsp;</td>\n";
        $html .= "  </tr>\n";
    }

    if (($users_birthdays_array = user_get_todays_birthdays()) !== false) {

        $html .= "  <tr>\n";
        $html .= "    <td>";

        if (count($users_birthdays_array) == 1) {
            $html .= gettext("<b>1</b> member is celebrating their birthday today:");
        } else {
            $html .= sprintf(gettext("<b>%d</b> members are celebrating their birthdays today:"), format_number(count($users_birthdays_array)));
        }

        $html .= "</td>\n";
        $html .= "  </tr>\n";

        $users_array = array();

        foreach ($users_birthdays_array as $user) {

            $user_avatar = '';

            $user_logon = format_user_name($user['LOGON'], $user['NICKNAME']);

            $user_display = str_replace(" ", "&nbsp;", word_filter_add_ob_tags($user_logon, true));

            if ($user['UID'] == $_SESSION['UID']) {

                $user_title = gettext("You");
                $user_class = 'user_stats_curuser';

            } else if (($user['RELATIONSHIP'] & USER_FRIEND) > 0) {

                $user_title = gettext("Friend");
                $user_class = 'user_stats_friend';

            } else {

                $user_class = 'user_stats_normal';
                $user_title = '';
            }

            if (isset($user['AVATAR_URL']) && strlen($user['AVATAR_URL']) > 0) {

                $user_avatar = html_style_image(
                    'profile_image profile_image_small',
                    htmlentities_array($user_title),
                    null,
                    array(
                        'background-image' => sprintf(
                            "url('%s')",
                            $user['AVATAR_URL']
                        )
                    )
                );

            } else if (isset($user['AVATAR_AID']) && is_numeric($user['AVATAR_AID'])) {

                $attachment = attachments_get_by_aid($user['AVATAR_AID']);

                if (($user_avatar_picture = attachments_make_link($attachment, false, false, false, false)) !== false) {

                    $user_avatar = html_style_image(
                        'profile_image profile_image_small',
                        htmlentities_array($user_title),
                        null,
                        array(
                            'background-image' => sprintf(
                                "url('%s&amp;profile_picture')",
                                $user_avatar_picture
                            )
                        )
                    );
                }
            }

            $users_array[] = sprintf(
                $user_profile_link,
                $user_avatar,
                $webtag,
                $user['UID'],
                $user_class,
                $user_title,
                $user_display
            );
        }

        $html .= "  <tr>\n";
        $html .= "    <td class=\"birthdayusers\">\n";
        $html .= "      " . implode(", ", $users_array) . "\n";
        $html .= "    </td>\n";
        $html .= "  </tr>\n";
        $html .= "  <tr>\n";
        $html .= "    <td>&nbsp;</td>\n";
        $html .= "  </tr>\n";
    }

    $thread_count = stats_get_thread_count();

    $post_count = stats_get_post_count();

    $html .= "  <tr>\n";
    $html .= "    <td>";

    if ($thread_count <> 1) {
        $num_threads_display = sprintf(gettext("<b>%s</b> threads"), format_number($thread_count));
    } else {
        $num_threads_display = gettext("<b>1</b> thread");
    }

    if ($post_count <> 1) {
        $num_posts_display = sprintf(gettext("<b>%s</b> posts"), format_number($post_count));
    } else {
        $num_posts_display = gettext("<b>1</b> post");
    }

    $html .= sprintf(gettext("Our members have made a total of %s and %s."), $num_threads_display, $num_posts_display) . '<br />';
    $html .= "  </tr>\n";
    $html .= "  <tr>\n";
    $html .= "    <td>&nbsp;</td>\n";
    $html .= "  </tr>\n";

    if (($longest_thread = stats_get_longest_thread()) !== false) {

        $html .= "  <tr>\n";
        $html .= "    <td>";

        $longest_thread_title = word_filter_add_ob_tags($longest_thread['TITLE'], true);

        $longest_thread_link = sprintf("<a href=\"index.php?webtag=$webtag&amp;msg=%d.1\">%s</a>", $longest_thread['TID'], $longest_thread_title);
        $longest_thread_post_count = ($longest_thread['LENGTH'] <> 1) ? sprintf(gettext("<b>%s</b> posts"), format_number($longest_thread['LENGTH'])) : gettext("<b>1</b> post");

        $html .= sprintf(gettext("Longest thread is <b>%s</b> with %s."), $longest_thread_link, $longest_thread_post_count);

        $html .= "    </td>\n";
        $html .= "  </tr>\n";
    }

    if (($most_read_thread = stats_get_most_read_thread()) !== false) {

        $html .= "  <tr>\n";
        $html .= "    <td>";

        $most_read_thread_title = word_filter_add_ob_tags($most_read_thread['TITLE'], true);

        $most_read_thread_link = sprintf("<a href=\"index.php?webtag=$webtag&amp;msg=%d.1\">%s</a>", $most_read_thread['TID'], $most_read_thread_title);
        $most_read_thread_view_count = ($most_read_thread['VIEWCOUNT'] <> 1) ? sprintf(gettext("<b>%s</b> views"), format_number($most_read_thread['VIEWCOUNT'])) : gettext("<b>1</b> view");

        $html .= sprintf(gettext("Most read thread is <b>%s</b> with %s."), $most_read_thread_link, $most_read_thread_view_count);

        $html .= "    </td>\n";
        $html .= "  </tr>\n";
    }

    $html .= "  <tr>\n";
    $html .= "    <td>&nbsp;</td>\n";
    $html .= "  </tr>\n";
    $html .= "  <tr>\n";
    $html .= "    <td>";

    if ($recent_post_count <> 1) {
        $html .= sprintf(gettext("There have been <b>%s</b> posts made in the last 60 minutes."), format_number($recent_post_count));
    } else {
        $html .= gettext("There has been <b>1</b> post made in the last 60 minutes.");
    }

    $html .= "    </td>\n";
    $html .= "  </tr>\n";

    if (($most_posts = stats_get_most_posts()) !== false) {

        if (($most_posts['MOST_POSTS_COUNT'] > 0) && ($most_posts['MOST_POSTS_DATE'] > 0)) {

            $html .= "  <tr>\n";
            $html .= "    <td>";

            $html .= sprintf(
                gettext("Most posts ever made in a single 60 minute period is <b>%s</b> on %s."),
                format_number($most_posts['MOST_POSTS_COUNT']),
                format_date_time($most_posts['MOST_POSTS_DATE'])
            );

            $html .= "    </td>\n";
            $html .= "  </tr>\n";
        }
    }

    if (($user_count = user_count()) !== false) {

        $html .= "  <tr>\n";
        $html .= "    <td>&nbsp;</td>\n";
        $html .= "  </tr>\n";
        $html .= "  <tr>\n";
        $html .= "    <td>";

        if ($user_count <> 1) {

            if (($newest_member = stats_get_newest_user()) !== false) {

                $user_newest_display = word_filter_add_ob_tags(format_user_name($newest_member['LOGON'], $newest_member['NICKNAME']), true);
                $user_newest_profile_link = sprintf($new_user_profile_link, $webtag, $newest_member['UID'], $user_newest_display);

                $html .= sprintf(gettext("We have <b>%s</b> registered members and the newest member is <b>%s</b>."), format_number($user_count), $user_newest_profile_link);

            } else {

                $html .= sprintf(gettext("We have %s registered members."), $user_count);
            }

        } else {

            $html .= gettext("We have one registered member.");
        }

        $html .= "    </td>\n";
        $html .= "  </tr>\n";
    }

    if (($most_users = stats_get_most_users()) !== false) {

        if (($most_users['MOST_USERS_COUNT'] > 0) && ($most_users['MOST_USERS_DATE'] > 0)) {

            $html .= "  <tr>\n";
            $html .= "    <td>";

            $most_users_date = format_date_time($most_users['MOST_USERS_DATE']);
            $html .= sprintf(gettext("Most users ever online was <b>%s</b> on %s."), format_number($most_users['MOST_USERS_COUNT']), $most_users_date);

            $html .= "    </td>\n";
            $html .= "  </tr>\n";
        }
    }

    $html .= "  <tr>\n";
    $html .= "    <td>&nbsp;</td>\n";
    $html .= "  </tr>\n";
    $html .= "</table>\n";

    // Return the output buffer contents.
    return $html;
}

/**
 * @return bool|number
 */
function stats_get_active_session_count()
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!($forum_fid = get_forum_fid())) return false;

    /** @noinspection SpellCheckingInspection */
    $session_gc_max_lifetime = ini_get('session.gc_maxlifetime');

    $session_cutoff_datetime = date(MYSQL_DATETIME, time() - $session_gc_max_lifetime);

    $sql = "SELECT COUNT(UID) AS USER_COUNT FROM SESSIONS ";
    $sql .= "WHERE TIME >= CAST('$session_cutoff_datetime' AS DATETIME) ";
    $sql .= "AND FID = '$forum_fid'";

    if (!($result = $db->query($sql))) return false;

    list($user_count) = $result->fetch_row();

    return $user_count;
}

/**
 * @return bool|number
 */
function stats_get_active_registered_user_count()
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!($forum_fid = get_forum_fid())) return false;

    /** @noinspection SpellCheckingInspection */
    $session_gc_max_lifetime = ini_get('session.gc_maxlifetime');

    $session_cutoff_datetime = date(MYSQL_DATETIME, time() - $session_gc_max_lifetime);

    $sql = "SELECT COUNT(UID) AS REGISTERED_USER_COUNT FROM SESSIONS ";
    $sql .= "WHERE TIME >= CAST('$session_cutoff_datetime' AS DATETIME) ";
    $sql .= "AND FID = '$forum_fid' AND UID > 0";

    if (!($result = $db->query($sql))) return false;

    list($registered_user_count) = $result->fetch_row();

    return $registered_user_count;
}

/**
 * @return bool|number
 */
function stats_get_active_guest_count()
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!($forum_fid = get_forum_fid())) return false;

    /** @noinspection SpellCheckingInspection */
    $session_gc_max_lifetime = ini_get('session.gc_maxlifetime');

    $session_cutoff_datetime = date(MYSQL_DATETIME, time() - $session_gc_max_lifetime);

    $sql = "SELECT COUNT(UID) AS GUEST_COUNT FROM SESSIONS ";
    $sql .= "WHERE TIME >= CAST('$session_cutoff_datetime' AS DATETIME) ";
    $sql .= "AND FID = '$forum_fid' AND UID = 0";

    if (!($result = $db->query($sql))) return false;

    list($guest_count) = $result->fetch_row();

    return $guest_count;
}

/**
 * @return array|bool
 */
function stats_get_active_user_list()
{
    $stats = array(
        'ANON_USERS' => 0,
        'BOTS' => 0,
        'GUESTS' => 0,
        'USER_COUNT' => 0,
        'USERS' => array()
    );

    $user_sort = array();

    if (!$db = db::get()) return $stats;

    if (!($table_prefix = get_table_prefix())) return $stats;

    if (!($forum_fid = get_forum_fid())) return $stats;

    $session_gc_maxlifetime = ini_get('session.gc_maxlifetime');

    $session_cutoff_datetime = date(MYSQL_DATETIME, time() - $session_gc_maxlifetime);

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    $sql = "SELECT COUNT(UID) FROM SESSIONS WHERE UID = 0 AND SID IS NULL ";
    $sql .= "AND SESSIONS.TIME >= CAST('$session_cutoff_datetime' AS DATETIME) ";
    $sql .= "AND SESSIONS.FID = '$forum_fid'";

    if (!($result = $db->query($sql))) return $stats;

    list($stats['GUESTS']) = $result->fetch_row();

    $sql = "SELECT DISTINCT SESSIONS.UID, USER.LOGON, USER.NICKNAME, USER_PEER2.PEER_NICKNAME, ";
    $sql .= "USER_PREFS_GLOBAL.ANON_LOGON, USER_PEER.RELATIONSHIP AS PEER_RELATIONSHIP, ";
    $sql .= "USER_PEER2.RELATIONSHIP AS USER_RELATIONSHIP, SEARCH_ENGINE_BOTS.SID, ";
    $sql .= "SEARCH_ENGINE_BOTS.URL AS BOT_URL, SEARCH_ENGINE_BOTS.NAME AS BOT_NAME, ";
    $sql .= "USER_PREFS_FORUM.AVATAR_URL AS AVATAR_URL_FORUM, USER_PREFS_FORUM.AVATAR_AID AS AVATAR_AID_FORUM, ";
    $sql .= "USER_PREFS_GLOBAL.AVATAR_URL AS AVATAR_URL_GLOBAL, USER_PREFS_GLOBAL.AVATAR_AID AS AVATAR_AID_GLOBAL ";
    $sql .= "FROM SESSIONS SESSIONS LEFT JOIN USER USER ON (USER.UID = SESSIONS.UID) ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ";
    $sql .= "ON (USER_PEER.UID = SESSIONS.UID AND USER_PEER.PEER_UID = '{$_SESSION['UID']}') ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER2 ";
    $sql .= "ON (USER_PEER2.PEER_UID = SESSIONS.UID AND USER_PEER2.UID = '{$_SESSION['UID']}') ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_PREFS` USER_PREFS_FORUM ON (USER_PREFS_FORUM.UID = SESSIONS.UID) ";
    $sql .= "LEFT JOIN USER_PREFS USER_PREFS_GLOBAL ON (USER_PREFS_GLOBAL.UID = SESSIONS.UID) ";
    $sql .= "LEFT JOIN SEARCH_ENGINE_BOTS ON (SEARCH_ENGINE_BOTS.SID = SESSIONS.SID) ";
    $sql .= "WHERE SESSIONS.TIME >= CAST('$session_cutoff_datetime' AS DATETIME) ";
    $sql .= "AND SESSIONS.FID = '$forum_fid' AND (SESSIONS.UID > 0 OR SESSIONS.SID IS NOT NULL)";

    if (!($result = $db->query($sql))) return $stats;

    while (($user_data = $result->fetch_assoc()) !== null) {

        if (isset($user_data['ANON_LOGON']) && $user_data['ANON_LOGON'] > USER_ANON_DISABLED) {
            $anon_logon = $user_data['ANON_LOGON'];
        } else {
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

        if (isset($user_data['AVATAR_AID_FORUM']) && is_numeric($user_data['AVATAR_AID_FORUM'])) {
            $user_data['AVATAR_AID'] = $user_data['AVATAR_AID_FORUM'];
        } else if (isset($user_data['AVATAR_AID_GLOBAL']) && is_numeric($user_data['AVATAR_AID_GLOBAL'])) {
            $user_data['AVATAR_AID'] = $user_data['AVATAR_AID_GLOBAL'];
        } else {
            $user_data['AVATAR_AID'] = null;
        }

        if (!isset($user_data['LOGON'])) $user_data['LOGON'] = gettext("Unknown user");
        if (!isset($user_data['NICKNAME'])) $user_data['NICKNAME'] = "";

        if (($user_data['USER_RELATIONSHIP'] & USER_IGNORED_COMPLETELY) > 0) {

            unset($user_data);

        } else if (isset($user_data['SID']) && !is_null($user_data['SID'])) {

            if (forum_get_setting('searchbots_show_active', 'Y')) {

                $stats['BOTS']++;

                $user_sort[] = $user_data['BOT_NAME'];

                $stats['USERS'][] = array(
                    'BOT_NAME' => $user_data['BOT_NAME'],
                    'BOT_URL' => $user_data['BOT_URL']
                );

            } else {

                $stats['GUESTS']++;
            }

        } else {

            if (($anon_logon == USER_ANON_DISABLED) || ($user_data['UID'] == $_SESSION['UID']) || (($user_data['PEER_RELATIONSHIP'] & USER_FRIEND) > 0 && ($anon_logon == USER_ANON_FRIENDS_ONLY))) {

                $stats['USER_COUNT']++;

                $user_sort[] = format_user_name($user_data['LOGON'], $user_data['NICKNAME']);

                $stats['USERS'][] = array(
                    'UID' => $user_data['UID'],
                    'LOGON' => $user_data['LOGON'],
                    'NICKNAME' => $user_data['NICKNAME'],
                    'RELATIONSHIP' => $user_data['USER_RELATIONSHIP'],
                    'ANON_LOGON' => $anon_logon,
                    'AVATAR_URL' => $user_data['AVATAR_URL'],
                    'AVATAR_AID' => $user_data['AVATAR_AID']
                );

            } else {

                $stats['ANON_USERS']++;
            }
        }
    }

    $user_sort = array_map('strtolower', $user_sort);

    array_multisort($user_sort, SORT_ASC, SORT_STRING, $stats['USERS']);

    return $stats;
}

/**
 * @return bool|int
 */
function stats_get_thread_count()
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT COUNT(THREAD.TID) AS THREAD_COUNT ";
    $sql .= "FROM `{$table_prefix}THREAD` THREAD";

    if (!($result = $db->query($sql))) return false;

    list($thread_count) = $result->fetch_row();

    return $thread_count;
}

/**
 * @return bool|int
 */
function stats_get_post_count()
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT COUNT(POST.PID) AS POST_COUNT FROM `{$table_prefix}POST` POST";

    if (!($result = $db->query($sql))) return false;

    list($post_count) = $result->fetch_row();

    return $post_count;
}

/**
 * @return bool|int
 */
function stats_get_recent_post_count()
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $recent_post_datetime = date(MYSQL_DATETIME, time() - HOUR_IN_SECONDS);

    $sql = "SELECT COUNT(POST.PID) AS POSTS FROM `{$table_prefix}POST` POST ";
    $sql .= "WHERE CREATED >= CAST('$recent_post_datetime' AS DATETIME)";

    if (!($result = $db->query($sql))) return false;

    list($post_count) = $result->fetch_row();

    return $post_count;
}

/**
 * @return array|bool
 */
function stats_get_longest_thread()
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    // Get the folders the user can see.
    $folders = folder_get_available();

    // Find the longest thread.
    $sql = "SELECT MAX(LENGTH) FROM `{$table_prefix}THREAD` ";
    $sql .= "WHERE FID IN ($folders)";

    if (!($result = $db->query($sql))) return false;

    list($highest_thread_count) = $result->fetch_row();

    $sql = "SELECT THREAD.TID, THREAD.LENGTH, ";
    $sql .= "TRIM(CONCAT_WS(' ', COALESCE(FOLDER.PREFIX, ''), THREAD.TITLE)) AS TITLE ";
    $sql .= "FROM `{$table_prefix}THREAD` THREAD LEFT JOIN `{$table_prefix}FOLDER` FOLDER ";
    $sql .= "ON (FOLDER.FID = THREAD.FID) WHERE THREAD.LENGTH = '$highest_thread_count' ";
    $sql .= "AND THREAD.DELETED = 'N' LIMIT 0, 1";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    return $result->fetch_assoc();
}

/**
 * @return bool
 */
function stats_get_user_count()
{
    if (!$db = db::get()) return false;

    $sql = "SELECT COUNT(UID) AS COUNT FROM USER";

    if (!($result = $db->query($sql))) return false;

    list($user_count) = $result->fetch_row();

    return $user_count;
}

/**
 * @return array|bool
 */
function stats_get_most_users()
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT MOST_USERS_COUNT, UNIX_TIMESTAMP(MOST_USERS_DATE) AS MOST_USERS_DATE ";
    $sql .= "FROM `{$table_prefix}STATS`";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    return $result->fetch_assoc();
}

/**
 * @return array|bool
 */
function stats_get_most_posts()
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT MOST_POSTS_COUNT, UNIX_TIMESTAMP(MOST_POSTS_DATE) AS MOST_POSTS_DATE ";
    $sql .= "FROM `{$table_prefix}STATS`";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    return $result->fetch_assoc();
}

/**
 * @return array|bool
 */
function stats_get_newest_user()
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    $sql = "SELECT MAX(UID) FROM USER";

    if (!($result = $db->query($sql))) return false;

    list($newest_user_uid) = $result->fetch_row();

    $sql = "SELECT USER.UID, USER.LOGON, USER.NICKNAME, USER_PEER.PEER_NICKNAME ";
    $sql .= "FROM USER LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ";
    $sql .= "ON (USER_PEER.PEER_UID = USER.UID AND USER_PEER.UID = '{$_SESSION['UID']}') ";
    $sql .= "WHERE USER.UID = '$newest_user_uid'";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $user_data = $result->fetch_assoc();

    if (isset($user_data['LOGON']) && isset($user_data['PEER_NICKNAME'])) {
        if (!is_null($user_data['PEER_NICKNAME']) && strlen($user_data['PEER_NICKNAME']) > 0) {
            $user_data['NICKNAME'] = $user_data['PEER_NICKNAME'];
        }
    }

    if (!isset($user_data['LOGON'])) $user_data['LOGON'] = gettext("Unknown user");
    if (!isset($user_data['NICKNAME'])) $user_data['NICKNAME'] = "";

    return $user_data;
}

/**
 * @param $start_timestamp
 * @param $end_timestamp
 * @return array|bool
 */
function stats_get_post_tallys($start_timestamp, $end_timestamp)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($start_timestamp)) return false;
    if (!is_numeric($end_timestamp)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $post_tallys = array(
        'user_stats' => array(),
        'post_count' => 0
    );

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    $post_start_datetime = date(MYSQL_DATETIME, $start_timestamp);
    $post_end_datetime = date(MYSQL_DATETIME, $end_timestamp);

    $sql = "SELECT COUNT(POST.PID) AS TOTAL_POST_COUNT ";
    $sql .= "FROM `{$table_prefix}POST` POST ";
    $sql .= "WHERE POST.CREATED > CAST('$post_start_datetime' AS DATETIME) ";
    $sql .= "AND POST.CREATED < CAST('$post_end_datetime' AS DATETIME)";

    if (!($result = $db->query($sql))) return false;

    list($post_tallys['post_count']) = $result->fetch_row();

    $sql = "SELECT POST.FROM_UID AS UID, USER.LOGON, USER.NICKNAME, ";
    $sql .= "USER_PEER.PEER_NICKNAME, COUNT(POST.PID) AS POST_COUNT ";
    $sql .= "FROM `{$table_prefix}POST` POST ";
    $sql .= "LEFT JOIN USER USER ON (USER.UID = POST.FROM_UID) ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ";
    $sql .= "ON (USER_PEER.PEER_UID = USER.UID AND USER_PEER.UID = '{$_SESSION['UID']}') ";
    $sql .= "WHERE POST.CREATED > CAST('$post_start_datetime' AS DATETIME) ";
    $sql .= "AND POST.CREATED < CAST('$post_end_datetime' AS DATETIME) ";
    $sql .= "GROUP BY POST.FROM_UID ORDER BY POST_COUNT DESC ";
    $sql .= "LIMIT 0, 20";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows > 0) {

        while (($user_stats = $result->fetch_assoc()) !== null) {

            if (isset($user_stats['LOGON']) && isset($user_stats['PEER_NICKNAME'])) {
                if (!is_null($user_stats['PEER_NICKNAME']) && strlen($user_stats['PEER_NICKNAME']) > 0) {
                    $user_stats['NICKNAME'] = $user_stats['PEER_NICKNAME'];
                }
            }

            if (!isset($user_stats['LOGON'])) $user_stats['LOGON'] = gettext("Unknown user");
            if (!isset($user_stats['NICKNAME'])) $user_stats['NICKNAME'] = "";

            $post_tallys['user_stats'][] = $user_stats;
        }
    }

    return $post_tallys;
}

/**
 * @return array|bool
 */
function stats_get_top_poster()
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT POST.FROM_UID AS UID, USER.LOGON, USER.NICKNAME, ";
    $sql .= "COUNT(POST.PID) AS POST_COUNT FROM `{$table_prefix}POST` POST ";
    $sql .= "LEFT JOIN USER USER ON (USER.UID = POST.FROM_UID) ";
    $sql .= "GROUP BY POST.FROM_UID ORDER BY POST_COUNT DESC ";
    $sql .= "LIMIT 0, 1";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    return $result->fetch_assoc();
}

/**
 * @return bool|int
 */
function stats_get_folder_count()
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT COUNT(FID) AS FOLDER_COUNT FROM `{$table_prefix}FOLDER`";

    if (!($result = $db->query($sql))) return false;

    list($folder_count) = $result->fetch_row();

    return $folder_count;
}

/**
 * @return array|bool
 */
function stats_get_folder_with_most_threads()
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT FOLDER.FID, FOLDER.TITLE, COUNT(THREAD.TID) AS THREAD_COUNT ";
    $sql .= "FROM `{$table_prefix}THREAD` THREAD ";
    $sql .= "LEFT JOIN `{$table_prefix}FOLDER` FOLDER ON (FOLDER.FID = THREAD.FID) ";
    $sql .= "GROUP BY THREAD.FID ORDER BY THREAD_COUNT DESC ";
    $sql .= "LIMIT 0, 1";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    return $result->fetch_assoc();
}

/**
 * @return array|bool
 */
function stats_get_folder_with_most_posts()
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT FOLDER.FID, FOLDER.TITLE, COUNT(POST.PID) AS POST_COUNT ";
    $sql .= "FROM `{$table_prefix}FOLDER` FOLDER ";
    $sql .= "LEFT JOIN `{$table_prefix}THREAD` THREAD ON (THREAD.FID = FOLDER.FID) ";
    $sql .= "LEFT JOIN `{$table_prefix}POST` POST ON (POST.TID = THREAD.TID) ";
    $sql .= "GROUP BY FOLDER.FID ORDER BY POST_COUNT DESC ";
    $sql .= "LIMIT 0, 1";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    return $result->fetch_assoc();
}

/**
 * @return array|bool
 */
function stats_get_most_read_thread()
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT THREAD.TID, THREAD_STATS.VIEWCOUNT, ";
    $sql .= "TRIM(CONCAT_WS(' ', COALESCE(FOLDER.PREFIX, ''), THREAD.TITLE)) AS TITLE ";
    $sql .= "FROM `{$table_prefix}THREAD_STATS` THREAD_STATS LEFT JOIN `{$table_prefix}THREAD` THREAD ";
    $sql .= "ON (THREAD.TID = THREAD_STATS.TID) LEFT JOIN `{$table_prefix}FOLDER` FOLDER ";
    $sql .= "ON (FOLDER.FID = THREAD.FID) ORDER BY THREAD_STATS.VIEWCOUNT DESC ";
    $sql .= "LIMIT 0, 1";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    return $result->fetch_assoc();
}

/**
 * @return bool|number
 */
function stats_get_thread_subscription_count()
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT COUNT(TID) AS SUBSCRIPTION_COUNT FROM `{$table_prefix}USER_THREAD` WHERE INTEREST = 2";

    if (!($result = $db->query($sql))) return false;

    list($subscription_count) = $result->fetch_row();

    return $subscription_count;
}

/**
 * @return array|bool
 */
function stats_get_most_subscribed_thread()
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT THREAD.TID, COUNT(USER_THREAD.INTEREST) AS SUBSCRIBERS, ";
    $sql .= "TRIM(CONCAT_WS(' ', COALESCE(FOLDER.PREFIX, ''), THREAD.TITLE)) AS TITLE ";
    $sql .= "FROM `{$table_prefix}USER_THREAD` USER_THREAD ";
    $sql .= "LEFT JOIN `{$table_prefix}THREAD` THREAD ON (THREAD.TID = USER_THREAD.TID) ";
    $sql .= "LEFT JOIN `{$table_prefix}FOLDER` FOLDER ON (FOLDER.FID = THREAD.FID) ";
    $sql .= "WHERE USER_THREAD.INTEREST = 2 GROUP BY USER_THREAD.TID ";
    $sql .= "ORDER BY SUBSCRIBERS DESC LIMIT 0, 1";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    return $result->fetch_assoc();
}

/**
 * @return bool|number
 */
function stats_get_poll_count()
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT COUNT(TID) AS POLL_COUNT FROM `{$table_prefix}POLL`";

    if (!($result = $db->query($sql))) return false;

    list($poll_count) = $result->fetch_row();

    return $poll_count;
}

/**
 * @return bool|number
 */
function stats_get_poll_option_count()
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT COUNT(*) AS POLL_OPTION_COUNT FROM `{$table_prefix}POLL_VOTES`";

    if (!($result = $db->query($sql))) return false;

    list($poll_option_count) = $result->fetch_row();

    return $poll_option_count;
}

/**
 * @return bool|number
 */
function stats_get_poll_vote_count()
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT COUNT(*) AS POLL_VOTE_COUNT FROM `{$table_prefix}USER_POLL_VOTES`";

    if (!($result = $db->query($sql))) return false;

    list($poll_vote_count) = $result->fetch_row();

    return $poll_vote_count;
}

/**
 * @return bool|number
 */
function stats_get_attachment_count()
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!($forum_fid = get_forum_fid())) return false;

    $sql = "SELECT COUNT(*) AS ATTACHMENT_COUNT FROM POST_ATTACHMENT_IDS PAI ";
    $sql .= "LEFT JOIN POST_ATTACHMENT_FILES PAF ON (PAF.AID = PAI.AID) ";
    $sql .= "WHERE PAI.FID = '$forum_fid' AND PAF.FILENAME IS NOT NULL";

    if (!($result = $db->query($sql))) return false;

    list($attachment_count) = $result->fetch_row();

    return $attachment_count;
}

/**
 * @return array|bool
 */
function stats_get_most_downloaded_attachment()
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!($attachment_dir = attachments_check_dir())) return false;

    if (!($forum_fid = get_forum_fid())) return false;

    $sql = "SELECT PAI.TID, PAI.PID, PAF.AID, PAF.HASH, PAF.FILENAME, ";
    $sql .= "PAF.MIMETYPE, PAF.DOWNLOADS FROM POST_ATTACHMENT_FILES PAF ";
    $sql .= "LEFT JOIN POST_ATTACHMENT_IDS PAI ON (PAI.AID = PAF.AID) ";
    $sql .= "WHERE PAI.FID = '$forum_fid' ";
    $sql .= "ORDER BY PAF.DOWNLOADS DESC ";

    if (!($result = $db->query($sql))) return false;

    while (($attachment_data = $result->fetch_assoc()) !== null) {

        if (@file_exists("$attachment_dir/{$attachment_data['HASH']}")) {

            if (@file_exists("$attachment_dir/{$attachment_data['HASH']}.thumb")) {

                $filesize = filesize("$attachment_dir/{$attachment_data['HASH']}");
                $filesize += filesize("$attachment_dir/{$attachment_data['HASH']}.thumb");

                return array(
                    "msg" => sprintf("%s.%s", $attachment_data['TID'], $attachment_data['PID']),
                    "filename" => rawurldecode($attachment_data['FILENAME']),
                    "filesize" => $filesize,
                    "aid" => $attachment_data['AID'],
                    "hash" => $attachment_data['HASH'],
                    "mimetype" => $attachment_data['MIMETYPE'],
                    "downloads" => $attachment_data['DOWNLOADS']
                );

            } else {

                return array(
                    "msg" => sprintf("%s.%s", $attachment_data['TID'], $attachment_data['PID']),
                    "filename" => rawurldecode($attachment_data['FILENAME']),
                    "filesize" => filesize("$attachment_dir/{$attachment_data['HASH']}"),
                    "aid" => $attachment_data['AID'],
                    "hash" => $attachment_data['HASH'],
                    "mimetype" => $attachment_data['MIMETYPE'],
                    "downloads" => $attachment_data['DOWNLOADS']
                );
            }
        }
    }

    return false;
}

/**
 * @return array|bool
 */
function stats_get_most_popular_forum_style()
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT USER_PREFS.STYLE, USERS.USER_COUNT FROM `{$table_prefix}USER_PREFS` USER_PREFS ";
    $sql .= "INNER JOIN (SELECT STYLE, COUNT(*) AS USER_COUNT FROM USER_PREFS GROUP BY STYLE LIMIT 1) AS USERS ";
    $sql .= "ON (USERS.STYLE = USER_PREFS.STYLE)";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    if (!($style_data = $result->fetch_assoc())) return false;

    return $style_data;
}

/**
 * @return array|bool
 */
function stats_get_most_popular_emoticon_pack()
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT USER_PREFS.EMOTICONS, USERS.USER_COUNT FROM `{$table_prefix}USER_PREFS` USER_PREFS ";
    $sql .= "INNER JOIN (SELECT EMOTICONS, COUNT(*) AS USER_COUNT FROM USER_PREFS GROUP BY EMOTICONS LIMIT 1) AS USERS ";
    $sql .= "ON (USERS.EMOTICONS = USER_PREFS.EMOTICONS)";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    if (!($emoticon_data = $result->fetch_assoc())) return false;

    return $emoticon_data;
}

/**
 * @return array|bool
 */
function stats_get_most_popular_language()
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT USER_PREFS.LANGUAGE, USERS.USER_COUNT FROM `{$table_prefix}USER_PREFS` USER_PREFS ";
    $sql .= "INNER JOIN (SELECT LANGUAGE, COUNT(*) AS USER_COUNT FROM USER_PREFS GROUP BY EMOTICONS LIMIT 1) AS USERS ";
    $sql .= "ON (USERS.LANGUAGE = USER_PREFS.LANGUAGE)";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    if (!($language_data = $result->fetch_assoc())) return false;

    return $language_data;
}

/**
 * @return array|bool
 */
function stats_get_most_popular_timezone()
{
    if (!$db = db::get()) return false;

    $sql = "SELECT TIMEZONE, COUNT(*) AS USER_COUNT FROM USER_PREFS ";
    $sql .= "GROUP BY TIMEZONE ORDER BY USER_COUNT DESC LIMIT 0,1";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $timezone_data = $result->fetch_assoc();

    return $timezone_data;
}

/**
 * @return bool|number
 */
function stats_get_inactive_user_count()
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT COUNT(UID) AS USER_COUNT FROM USER ";
    $sql .= "WHERE UID NOT IN (SELECT DISTINCT FROM_UID ";
    $sql .= "FROM `{$table_prefix}POST`)";

    if (!($result = $db->query($sql))) return false;

    list($user_count) = $result->fetch_row();

    return $user_count;
}

/**
 * @return bool|number
 */
function stats_get_active_user_count()
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT COUNT(DISTINCT FROM_UID) AS USER_COUNT FROM `{$table_prefix}POST`";

    if (!($result = $db->query($sql))) return false;

    list($user_count) = $result->fetch_row();

    return $user_count;
}

/**
 * @return array|bool
 */
function stats_get_visitor_counts()
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!($forum_fid = get_forum_fid())) return false;

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
    $sql .= "WHERE LAST_LOGON >= CAST('$day_start_datetime' AS DATETIME) ";
    $sql .= "AND FORUM = '$forum_fid'";

    if (!($result = $db->query($sql))) return false;

    list($visitors_today) = $result->fetch_row();

    $sql = "SELECT COUNT(UID) AS VISITOR_COUNT FROM VISITOR_LOG ";
    $sql .= "WHERE LAST_LOGON >= CAST('$week_start_datetime' AS DATETIME) ";
    $sql .= "AND FORUM = '$forum_fid'";

    if (!($result = $db->query($sql))) return false;

    list($visitors_this_week) = $result->fetch_row();

    $sql = "SELECT COUNT(UID) AS VISITOR_COUNT FROM VISITOR_LOG ";
    $sql .= "WHERE LAST_LOGON >= CAST('$month_start_datetime' AS DATETIME) ";
    $sql .= "AND FORUM = '$forum_fid'";

    if (!($result = $db->query($sql))) return false;

    list($visitors_this_month) = $result->fetch_row();

    $sql = "SELECT COUNT(UID) AS VISITOR_COUNT FROM VISITOR_LOG ";
    $sql .= "WHERE LAST_LOGON >= CAST('$year_start_datetime' AS DATETIME) ";
    $sql .= "AND FORUM = '$forum_fid'";

    if (!($result = $db->query($sql))) return false;

    list($visitors_this_year) = $result->fetch_row();

    return array(
        'DAY' => $visitors_today,
        'WEEK' => $visitors_this_week,
        'MONTH' => $visitors_this_month,
        'YEAR' => $visitors_this_year
    );
}

/**
 * @return bool|number
 */
function stats_get_average_age()
{
    if (!$db = db::get()) return false;

    // Year, Month and Day
    list($year, $month, $day) = explode('-', date(MYSQL_DATE, time()));

    $sql = "SELECT AVG($year - DATE_FORMAT(DOB, '%Y') - ";
    $sql .= "(CAST('00-$month-$day' AS DATE) < DATE_FORMAT(DOB, '00-%m-%d'))) AS AVERAGE_AGE ";
    $sql .= "FROM USER_PREFS WHERE DOB > 0";

    if (!($result = $db->query($sql))) return false;

    list($average_age) = $result->fetch_row();

    return is_numeric($average_age) ? $average_age : false;
}

/**
 * @return array|bool
 */
function stats_get_most_popular_birthday()
{
    if (!$db = db::get()) return false;

    $sql = "SELECT DATE_FORMAT(DOB, '0000-%m-%d') AS DOB, ";
    $sql .= "COUNT(*) AS DOB_COUNT FROM USER_PREFS WHERE DOB > 0 ";
    $sql .= "GROUP BY DOB ORDER BY DOB_COUNT DESC LIMIT 0, 1";

    if (!($result = $db->query($sql))) return false;

    $dob_data = $result->fetch_assoc();

    return $dob_data;
}

/**
 * @return bool|number
 */
function stats_get_users_without_profile_count()
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT COUNT(USER.UID) AS USER_COUNT FROM USER ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_PROFILE` USER_PROFILE ";
    $sql .= "ON (USER_PROFILE.UID = USER.UID) ";
    $sql .= "WHERE USER_PROFILE.ENTRY IS NULL";

    if (!($result = $db->query($sql))) return false;

    list($user_count) = $result->fetch_row();

    return $user_count;
}

/**
 * @return bool|number
 */
function stats_get_users_with_profile_count()
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT COUNT(DISTINCT UID) AS USER_COUNT FROM `{$table_prefix}USER_PROFILE`";

    if (!($result = $db->query($sql))) return false;

    list($user_count) = $result->fetch_row();

    return $user_count;
}

/**
 * @return bool|number
 */
function stats_get_users_without_signature_count()
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT COUNT(USER.UID) AS USER_COUNT FROM USER ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_SIG` USER_SIG ON (USER_SIG.UID = USER.UID) ";
    $sql .= "WHERE USER_SIG.CONTENT IS NULL";

    if (!($result = $db->query($sql))) return false;

    list($user_count) = $result->fetch_row();

    return $user_count;
}

/**
 * @return bool|number
 */
function stats_get_users_with_signature_count()
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT COUNT(DISTINCT UID) AS USER_COUNT FROM `{$table_prefix}USER_SIG`";

    if (!($result = $db->query($sql))) return false;

    list($user_count) = $result->fetch_row();

    return $user_count;
}

/**
 * @return bool|number
 */
function stats_get_relationships_count()
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT COUNT(*) AS RELATIONSHIP_COUNT FROM `{$table_prefix}USER_PEER`";

    if (!($result = $db->query($sql))) return false;

    list($relationship_count) = $result->fetch_row();

    return $relationship_count;
}

/**
 * @return bool|number
 */
function stats_get_users_without_word_filter_count()
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT COUNT(USER.UID) AS USER_COUNT FROM USER ";
    $sql .= "LEFT JOIN `{$table_prefix}WORD_FILTER` WORD_FILTER ON (WORD_FILTER.UID = USER.UID) ";
    $sql .= "WHERE WORD_FILTER.MATCH_TEXT IS NULL";

    if (!($result = $db->query($sql))) return false;

    list($user_count) = $result->fetch_row();

    return $user_count;
}

/**
 * @return bool|number
 */
function stats_get_users_with_word_filter_count()
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT COUNT(DISTINCT UID) AS USER_COUNT ";
    $sql .= "FROM `{$table_prefix}WORD_FILTER` ";
    $sql .= "WHERE UID > 0";

    if (!($result = $db->query($sql))) return false;

    list($user_count) = $result->fetch_row();

    return $user_count;
}

/**
 * @param mixed &$week_start
 * @param mixed &$week_end
 * @return bool
 */
function stats_get_mysql_week(&$week_start, &$week_end)
{
    if (!$db = db::get()) return false;

    $sql = "SELECT UNIX_TIMESTAMP(DATE_SUB(CURDATE(), INTERVAL(DAYOFWEEK(CURDATE()) - 1) DAY)) AS WEEK_START, ";
    $sql .= "UNIX_TIMESTAMP(DATE_ADD(CURDATE(), INTERVAL(7 - DAYOFWEEK(CURDATE())) DAY)) AS WEEK_END";

    if (!($result = $db->query($sql))) return false;

    list($week_start, $week_end) = $result->fetch_row();

    return true;
}
