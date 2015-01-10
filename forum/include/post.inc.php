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
require_once BH_INCLUDE_PATH . 'constants.inc.php';
require_once BH_INCLUDE_PATH . 'db.inc.php';
require_once BH_INCLUDE_PATH . 'fixhtml.inc.php';
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'forum.inc.php';
require_once BH_INCLUDE_PATH . 'html.inc.php';
require_once BH_INCLUDE_PATH . 'ip.inc.php';
require_once BH_INCLUDE_PATH . 'perm.inc.php';
require_once BH_INCLUDE_PATH . 'poll.inc.php';
require_once BH_INCLUDE_PATH . 'session.inc.php';
require_once BH_INCLUDE_PATH . 'user.inc.php';
require_once BH_INCLUDE_PATH . 'word_filter.inc.php';
// End Required includes

function post_create($fid, $tid, $reply_pid, $from_uid, $to_user_array, $content)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($tid)) return false;

    if (!is_numeric($reply_pid)) return false;

    if (!is_numeric($from_uid)) return false;

    if (!is_array($to_user_array)) return false;

    $post_content = $db->escape($content);

    $ipaddress = get_ip_address();

    foreach ($to_user_array as $to_user) {

        if (!isset($to_user['UID']) || !is_numeric($to_user['UID'])) {
            return false;
        }
    }

    $current_datetime = date(MYSQL_DATETIME, time());

    if (!($table_prefix = get_table_prefix())) return false;

    $approved_by = 'NULL';

    $approved_datetime = 'NULL';

    if (!perm_check_folder_permissions($fid, USER_PERM_POST_APPROVAL, $from_uid) || perm_is_moderator($from_uid, $fid)) {

        $approved_by = $from_uid;

        $approved_datetime = sprintf(
            "CAST('%s' AS DATETIME)",
            date(MYSQL_DATETIME, time())
        );
    }

    $sql = "INSERT INTO `{$table_prefix}POST` (TID, REPLY_TO_PID, FROM_UID, ";
    $sql .= "CREATED, APPROVED, APPROVED_BY, IPADDRESS) VALUES ($tid, $reply_pid, ";
    $sql .= "$from_uid, CAST('$current_datetime' AS DATETIME), $approved_datetime, ";
    $sql .= "$approved_by, '$ipaddress')";

    if (!$db->query($sql)) return false;

    $new_pid = $db->insert_id;

    foreach ($to_user_array as $to_user) {

        $sql = "INSERT INTO `{$table_prefix}POST_RECIPIENT` (TID, PID, TO_UID) ";
        $sql .= "VALUES ('$tid', '$new_pid', '{$to_user['UID']}')";

        if (!$db->query($sql)) return false;
    }

    $sql = "INSERT INTO `{$table_prefix}POST_CONTENT` (TID, PID, CONTENT) ";
    $sql .= "VALUES ('$tid', '$new_pid', '$post_content')";

    if (!$db->query($sql)) return false;

    $sql = "INSERT INTO `{$table_prefix}POST_SEARCH_ID` (TID, PID) ";
    $sql .= "VALUES('$tid', '$new_pid')";

    if (!$db->query($sql)) return false;

    if (preg_match_all('/(^|\s)#([A-Z0-9]{1,255})/iu', $content, $tag_matches_array)) {
        post_add_tags($tid, $new_pid, $tag_matches_array[2]);
    }

    post_update_thread_length($tid, $new_pid);

    user_increment_post_count($from_uid);

    return $new_pid;
}

function post_approve($tid, $pid)
{
    if (!is_numeric($tid)) return false;
    if (!is_numeric($pid)) return false;

    if (!$db = db::get()) return false;

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $current_datetime = date(MYSQL_DATETIME, time());

    $sql = "UPDATE LOW_PRIORITY `{$table_prefix}POST` ";
    $sql .= "SET APPROVED = CAST('$current_datetime' AS DATETIME), ";
    $sql .= "APPROVED_BY = '{$_SESSION['UID']}' WHERE TID = '$tid' ";
    $sql .= "AND PID = '$pid'";

    if (!$db->query($sql)) return false;

    if ($pid == 1) {

        $sql = "UPDATE LOW_PRIORITY `{$table_prefix}THREAD` ";
        $sql .= "SET APPROVED = CAST('$current_datetime' AS DATETIME), ";
        $sql .= "APPROVED_BY = '{$_SESSION['UID']}' WHERE TID = '$tid'";

        if (!$db->query($sql)) return false;
    }

    return true;
}

function post_remove_attachments($tid, $pid)
{
    if (!is_numeric($tid)) return false;
    if (!is_numeric($pid)) return false;

    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!($forum_fid = get_forum_fid())) return false;

    $sql = "DELETE QUICK FROM POST_ATTACHMENT_IDS ";
    $sql .= "WHERE FID = '$forum_fid' AND TID = '$tid' ";
    $sql .= "AND PID = '$pid'";

    if (!$db->query($sql)) return false;

    return true;
}

function post_add_attachment($tid, $pid, $aid)
{
    if (!is_numeric($tid)) return false;
    if (!is_numeric($pid)) return false;
    if (!is_numeric($aid)) return false;

    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!($forum_fid = get_forum_fid())) return false;

    $sql = "INSERT IGNORE INTO POST_ATTACHMENT_IDS (FID, TID, PID, AID) ";
    $sql .= "VALUES ($forum_fid, $tid, $pid, $aid)";

    if (!$db->query($sql)) return false;

    return true;
}

function post_create_thread($fid, $uid, $title, $poll = 'N', $sticky = 'N', $closed = false, $deleted = false)
{
    if (!is_numeric($fid)) return false;

    if (!is_numeric($uid)) return false;

    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $title = $db->escape($title);

    $poll = ($poll == 'Y') ? 'Y' : 'N';

    $sticky = ($sticky == 'Y') ? 'Y' : 'N';

    $closed = ($closed === true) ? sprintf("'%s'", date(MYSQL_DATETIME, time())) : 'NULL';

    $deleted = ($deleted === true) ? 'Y' : 'N';

    $current_datetime = date(MYSQL_DATETIME, time());

    $approved_by = 'NULL';

    $approved_datetime = 'NULL';

    if (!perm_check_folder_permissions($fid, USER_PERM_POST_APPROVAL, $uid) || perm_is_moderator($uid, $fid)) {

        $approved_by = $uid;

        $approved_datetime = sprintf(
            "CAST('%s' AS DATETIME)",
            date(MYSQL_DATETIME, time())
        );
    }

    $sql = "INSERT INTO `{$table_prefix}THREAD` (FID, BY_UID, TITLE, LENGTH, POLL_FLAG, ";
    $sql .= "APPROVED, APPROVED_BY, STICKY, CREATED, MODIFIED, CLOSED, DELETED) ";
    $sql .= "VALUES ('$fid', '$uid', '$title', 0, '$poll', $approved_datetime, ";
    $sql .= "$approved_by, '$sticky', CAST('$current_datetime' AS DATETIME), ";
    $sql .= "CAST('$current_datetime' AS DATETIME), $closed, '$deleted')";

    if (!$db->query($sql)) return false;

    return $db->insert_id;
}

function post_update_thread_length($tid, $length)
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!is_numeric($tid)) return false;
    if (!is_numeric($length)) return false;

    $current_datetime = date(MYSQL_DATETIME, time());

    $sql = "UPDATE LOW_PRIORITY `{$table_prefix}THREAD` SET LENGTH = '$length', ";
    $sql .= "MODIFIED = CAST('$current_datetime' AS DATETIME) ";
    $sql .= "WHERE TID = '$tid'";

    if (!$db->query($sql)) return false;

    if (($unread_cutoff_datetime = forum_get_unread_cutoff_datetime()) !== false) {

        $sql = "INSERT INTO `{$table_prefix}THREAD` (TID, UNREAD_PID) ";
        $sql .= "SELECT THREAD.TID, MAX(POST.PID) AS UNREAD_PID FROM `{$table_prefix}THREAD` THREAD ";
        $sql .= "LEFT JOIN `{$table_prefix}POST` POST ON (POST.TID = THREAD.TID) ";
        $sql .= "WHERE POST.CREATED < CAST('$unread_cutoff_datetime' AS DATETIME) ";
        $sql .= "AND THREAD.TID = '$tid' GROUP BY THREAD.TID ";
        $sql .= "ON DUPLICATE KEY UPDATE UNREAD_PID = VALUES(UNREAD_PID)";

        if (!$db->query($sql)) return false;
    }

    return true;
}

function post_draw_to_dropdown($default_uid, $show_all = true)
{
    $class = defined('BEEHIVEMODE_LIGHT') ? 'select' : 'bhselect';

    $html = "<select name=\"t_to_uid\" class=\"$class\">";

    if (!$db = db::get()) return false;

    if (!is_numeric($default_uid)) $default_uid = 0;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!($forum_fid = get_forum_fid())) return false;

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    if (isset($default_uid) && $default_uid > 0) {

        $sql = "SELECT USER.LOGON, USER.NICKNAME, USER_PEER.PEER_NICKNAME ";
        $sql .= "FROM USER LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ";
        $sql .= "ON (USER_PEER.PEER_UID = USER.UID AND USER_PEER.UID = '{$_SESSION['UID']}') ";
        $sql .= "WHERE USER.UID = '$default_uid' ";

        if (!($result = $db->query($sql))) return false;

        if ($result->num_rows > 0) {

            $top_user = $result->fetch_assoc();

            if (isset($top_user['PEER_NICKNAME'])) {
                if (!is_null($top_user['PEER_NICKNAME']) && strlen($top_user['PEER_NICKNAME']) > 0) {
                    $top_user['NICKNAME'] = $top_user['PEER_NICKNAME'];
                }
            }

            $fmt_username = word_filter_add_ob_tags(format_user_name($top_user['LOGON'], $top_user['NICKNAME']), true);
            $html .= "<option value=\"$default_uid\" selected=\"selected\">$fmt_username</option>";
        }
    }

    if ($show_all) {
        $html .= "<option value=\"0\">" . gettext("ALL") . "</option>";
    }

    $sql = "SELECT VISITOR_LOG.UID, USER.LOGON, USER.NICKNAME, USER_PEER.PEER_NICKNAME, ";
    $sql .= "UNIX_TIMESTAMP(VISITOR_LOG.LAST_LOGON) AS LAST_LOGON FROM VISITOR_LOG VISITOR_LOG ";
    $sql .= "LEFT JOIN USER USER ON (USER.UID = VISITOR_LOG.UID) ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ";
    $sql .= "ON (USER_PEER.PEER_UID = USER.UID AND USER_PEER.UID = '{$_SESSION['UID']}') ";
    $sql .= "WHERE VISITOR_LOG.FORUM = '$forum_fid' AND VISITOR_LOG.UID <> '$default_uid' ";
    $sql .= "AND VISITOR_LOG.UID > 0 ORDER BY VISITOR_LOG.LAST_LOGON DESC ";
    $sql .= "LIMIT 0, 20";

    if (!($result = $db->query($sql))) return false;

    while (($user_data = $result->fetch_assoc()) !== null) {

        if (isset($user_data['LOGON'])) {

            if (isset($user_data['LOGON']) && isset($user_data['PEER_NICKNAME'])) {
                if (!is_null($user_data['PEER_NICKNAME']) && strlen($user_data['PEER_NICKNAME']) > 0) {
                    $user_data['NICKNAME'] = $user_data['PEER_NICKNAME'];
                }
            }

            $fmt_username = word_filter_add_ob_tags(format_user_name($user_data['LOGON'], $user_data['NICKNAME']), true);
            $html .= "<option value=\"{$user_data['UID']}\">$fmt_username</option>";
        }
    }

    $html .= "</select>";
    return $html;
}

function post_draw_to_dropdown_recent($default_uid)
{
    $class = defined('BEEHIVEMODE_LIGHT') ? 'select' : 'recent_user_dropdown';

    $html = "<select name=\"t_to_uid_recent\" class=\"$class\">";

    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!is_numeric($default_uid)) $default_uid = 0;

    if (!($forum_fid = get_forum_fid())) return false;

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    if (isset($default_uid) && $default_uid != 0) {

        $sql = "SELECT USER.LOGON, USER.NICKNAME, USER_PEER.PEER_NICKNAME ";
        $sql .= "FROM USER LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ";
        $sql .= "ON (USER_PEER.PEER_UID = USER.UID AND USER_PEER.UID = '{$_SESSION['UID']}') ";
        $sql .= "WHERE USER.UID = '$default_uid' ";

        if (!($result = $db->query($sql))) return false;

        if ($result->num_rows > 0) {

            $top_user = $result->fetch_assoc();

            if (isset($top_user['PEER_NICKNAME'])) {
                if (!is_null($top_user['PEER_NICKNAME']) && strlen($top_user['PEER_NICKNAME']) > 0) {
                    $top_user['NICKNAME'] = $top_user['PEER_NICKNAME'];
                }
            }

            $fmt_username = word_filter_add_ob_tags(format_user_name($top_user['LOGON'], $top_user['NICKNAME']), true);
            $html .= "<option value=\"$default_uid\" selected=\"selected\">$fmt_username</option>";
        }
    }

    $html .= "<option value=\"0\">" . gettext("ALL") . "</option>";

    $sql = "SELECT VISITOR_LOG.UID, USER.LOGON, USER.NICKNAME, USER_PEER.PEER_NICKNAME, ";
    $sql .= "UNIX_TIMESTAMP(VISITOR_LOG.LAST_LOGON) AS LAST_LOGON FROM VISITOR_LOG VISITOR_LOG ";
    $sql .= "LEFT JOIN USER USER ON (USER.UID = VISITOR_LOG.UID) ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ";
    $sql .= "ON (USER_PEER.PEER_UID = USER.UID AND USER_PEER.UID = '{$_SESSION['UID']}') ";
    $sql .= "WHERE VISITOR_LOG.FORUM = '$forum_fid' AND VISITOR_LOG.UID <> '$default_uid' ";
    $sql .= "AND VISITOR_LOG.UID > 0 ORDER BY VISITOR_LOG.LAST_LOGON DESC ";
    $sql .= "LIMIT 0, 20";

    if (!($result = $db->query($sql))) return false;

    while (($user_data = $result->fetch_assoc()) !== null) {

        if (isset($user_data['LOGON'])) {

            if (isset($user_data['LOGON']) && isset($user_data['PEER_NICKNAME'])) {
                if (!is_null($user_data['PEER_NICKNAME']) && strlen($user_data['PEER_NICKNAME']) > 0) {
                    $user_data['NICKNAME'] = $user_data['PEER_NICKNAME'];
                }
            }

            $fmt_username = word_filter_add_ob_tags(format_user_name($user_data['LOGON'], $user_data['NICKNAME']), true);
            $html .= "<option value=\"{$user_data['UID']}\">$fmt_username</option>";
        }
    }

    $html .= "</select>";
    return $html;
}

function post_draw_to_dropdown_in_thread($tid, $default_uid, $show_all = true, $inc_blank = false, $class = 'user_in_thread_dropdown', $custom_html = "")
{
    $html = "<select name=\"t_to_uid_in_thread\" class=\"$class\" $custom_html>";

    if (!$db = db::get()) return false;

    if (!is_numeric($tid)) return false;
    if (!is_numeric($default_uid)) $default_uid = 0;

    if (!($table_prefix = get_table_prefix())) return "";

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    if (isset($default_uid) && $default_uid != 0) {

        $sql = "SELECT USER.LOGON, USER.NICKNAME, USER_PEER.PEER_NICKNAME ";
        $sql .= "FROM USER LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ";
        $sql .= "ON (USER_PEER.PEER_UID = USER.UID AND USER_PEER.UID = '{$_SESSION['UID']}') ";
        $sql .= "WHERE USER.UID = '$default_uid' ";

        if (!($result = $db->query($sql))) return false;

        if ($result->num_rows > 0) {

            $top_user = $result->fetch_assoc();

            if (isset($top_user['PEER_NICKNAME'])) {
                if (!is_null($top_user['PEER_NICKNAME']) && strlen($top_user['PEER_NICKNAME']) > 0) {
                    $top_user['NICKNAME'] = $top_user['PEER_NICKNAME'];
                }
            }

            $fmt_username = word_filter_add_ob_tags(format_user_name($top_user['LOGON'], $top_user['NICKNAME']), true);
            $html .= "<option value=\"$default_uid\" selected=\"selected\">$fmt_username</option>";
        }
    }

    if ($show_all) {

        $html .= "<option value=\"0\">" . gettext("ALL") . "</option>";

    } else if ($inc_blank) {

        if (isset($default_uid) && $default_uid != 0) {
            $html .= "<option value=\"0\">&nbsp;</option>";
        } else {
            $html .= "<option value=\"0\" selected=\"selected\">&nbsp;</option>";
        }
    }

    $sql = "SELECT POST.FROM_UID AS UID, USER.LOGON, USER.NICKNAME, ";
    $sql .= "USER_PEER.PEER_NICKNAME FROM `{$table_prefix}POST` POST ";
    $sql .= "LEFT JOIN USER USER ON (USER.UID = POST.FROM_UID) ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ";
    $sql .= "ON (USER_PEER.PEER_UID = POST.FROM_UID AND USER_PEER.UID = '{$_SESSION['UID']}') ";
    $sql .= "WHERE POST.TID = '$tid' AND POST.FROM_UID <> '$default_uid' ";
    $sql .= "GROUP BY POST.FROM_UID LIMIT 0, 20";

    if (!($result = $db->query($sql))) return false;

    while (($user_data = $result->fetch_assoc()) !== null) {

        if (isset($user_data['LOGON'])) {

            if (isset($user_data['LOGON']) && isset($user_data['PEER_NICKNAME'])) {
                if (!is_null($user_data['PEER_NICKNAME']) && strlen($user_data['PEER_NICKNAME']) > 0) {
                    $user_data['NICKNAME'] = $user_data['PEER_NICKNAME'];
                }
            }

            $fmt_username = word_filter_add_ob_tags(format_user_name($user_data['LOGON'], $user_data['NICKNAME']), true);
            $html .= "<option value=\"{$user_data['UID']}\">$fmt_username</option>";
        }
    }

    $html .= "</select>";
    return $html;
}

function post_check_ddkey($ddkey)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($ddkey)) return false;

    $ddkey_datetime = date(MYSQL_DATETIME, $ddkey);

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT USER_VALUE FROM `{$table_prefix}USER_TRACK` ";
    $sql .= "WHERE UID = '{$_SESSION['UID']}' AND USER_KEY = 'DDKEY'";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows) {

        list($ddkey_datetime_check) = $result->fetch_row();

        $sql = "UPDATE LOW_PRIORITY `{$table_prefix}USER_TRACK` ";
        $sql .= "SET USER_VALUE = CAST('$ddkey_datetime' AS DATETIME) ";
        $sql .= "WHERE UID = '{$_SESSION['UID']}' AND USER_KEY = 'DDKEY'";

        if (!($result = $db->query($sql))) return false;

    } else {

        $ddkey_datetime_check = '';

        $sql = "INSERT INTO `{$table_prefix}USER_TRACK` (UID, USER_KEY, USER_VALUE) ";
        $sql .= "VALUES ('{$_SESSION['UID']}', 'DDKEY', CAST('$ddkey_datetime' AS DATETIME))";

        if (!($result = $db->query($sql))) return false;
    }

    return !($ddkey_datetime == $ddkey_datetime_check);
}

function post_check_frequency()
{
    if (!$db = db::get()) return false;

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $minimum_post_frequency = intval(forum_get_setting('minimum_post_frequency', null, 0));

    if ($minimum_post_frequency == 0) return true;

    $current_datetime = date(MYSQL_DATE_HOUR_MIN, time());

    $sql = "SELECT UNIX_TIMESTAMP(USER_VALUE) + $minimum_post_frequency, ";
    $sql .= "UNIX_TIMESTAMP('$current_datetime') FROM `{$table_prefix}USER_TRACK` ";
    $sql .= "WHERE UID = '{$_SESSION['UID']}' AND USER_KEY = 'LAST_POST'";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows > 0) {

        list($last_post_stamp, $current_timestamp) = $result->fetch_row();

        if (!is_numeric($last_post_stamp) || $last_post_stamp < $current_timestamp) {

            $sql = "UPDATE LOW_PRIORITY `{$table_prefix}USER_TRACK` ";
            $sql .= "SET USER_VALUE = CAST('$current_datetime' AS DATETIME) ";
            $sql .= "WHERE UID = '{$_SESSION['UID']}' AND USER_KEY = 'LAST_POST'";

            if (!($result = $db->query($sql))) return false;

            return true;
        }

    } else {

        $sql = "INSERT INTO `{$table_prefix}USER_TRACK` (UID, USER_KEY, USER_VALUE) ";
        $sql .= "VALUES ('{$_SESSION['UID']}', 'LAST_POST', CAST('$current_datetime' AS DATETIME))";

        if (!($result = $db->query($sql))) return false;

        return true;
    }

    return false;
}

function post_update($fid, $tid, $pid, $content)
{
    if (!is_numeric($tid)) return false;
    if (!is_numeric($pid)) return false;

    if (!$db = db::get()) return false;

    $content = $db->escape($content);

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "UPDATE LOW_PRIORITY `{$table_prefix}POST_CONTENT` SET CONTENT = '$content' ";
    $sql .= "WHERE TID = '$tid' AND PID = '$pid' LIMIT 1";

    if (!$db->query($sql)) return false;

    $sql = "UPDATE LOW_PRIORITY `{$table_prefix}POST` SET INDEXED = NULL ";
    $sql .= "WHERE TID = '$tid' AND PID = '$pid' LIMIT 1";

    if (!$db->query($sql)) return false;

    if (session::check_perm(USER_PERM_POST_APPROVAL, $fid) && !session::check_perm(USER_PERM_FOLDER_MODERATE, $fid)) {

        $sql = "UPDATE LOW_PRIORITY `{$table_prefix}POST` SET APPROVED = NULL, APPROVED_BY = NULL ";
        $sql .= "WHERE TID = '$tid' AND PID = '$pid' LIMIT 1";

        if (!$db->query($sql)) return false;
    }

    if (preg_match_all('/(^|\s)#([A-Z0-9]{1,255})/iu', $content, $tag_matches_array)) {
        post_add_tags($tid, $pid, $tag_matches_array[2]);
    }

    return true;
}

function post_add_edit_text($tid, $pid)
{
    if (!is_numeric($tid)) return false;
    if (!is_numeric($pid)) return false;

    if (!$db = db::get()) return false;

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $current_datetime = date(MYSQL_DATETIME, time());

    $sql = "UPDATE LOW_PRIORITY `{$table_prefix}POST` ";
    $sql .= "SET EDITED = CAST('$current_datetime' AS DATETIME), ";
    $sql .= "EDITED_BY = '{$_SESSION['UID']}' WHERE TID = '$tid' AND PID = '$pid'";

    if (!$db->query($sql)) return false;

    return true;
}

function post_delete($tid, $pid)
{
    if (!is_numeric($tid)) return false;
    if (!is_numeric($pid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!$db = db::get()) return false;

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    $current_datetime = date(MYSQL_DATETIME, time());

    $modified_cutoff_datetime = forum_get_unread_cutoff_datetime();

    if (thread_is_poll($tid) && $pid == 1) {

        $sql = "UPDATE LOW_PRIORITY `{$table_prefix}THREAD` SET POLL_FLAG = 'N', ";
        $sql .= "MODIFIED = IF(MODIFIED < CAST('$modified_cutoff_datetime' AS DATETIME), ";
        $sql .= "MODIFIED, CAST('$current_datetime' AS DATETIME)) WHERE TID = '$tid'";

        if (!$db->query($sql)) return false;
    }

    $sql = "UPDATE LOW_PRIORITY `{$table_prefix}THREAD` SET DELETED = 'Y', ";
    $sql .= "MODIFIED = IF(MODIFIED < CAST('$modified_cutoff_datetime' AS DATETIME), ";
    $sql .= "MODIFIED, CAST('$current_datetime' AS DATETIME)) WHERE TID = '$tid' ";
    $sql .= "AND LENGTH = 1";

    if (!$db->query($sql)) return false;

    $sql = "UPDATE LOW_PRIORITY `{$table_prefix}POST_CONTENT` SET CONTENT = NULL ";
    $sql .= "WHERE TID = '$tid' AND PID = '$pid'";

    if (!$db->query($sql)) return false;

    $sql = "UPDATE LOW_PRIORITY `{$table_prefix}POST` ";
    $sql .= "SET APPROVED = CAST('$current_datetime' AS DATETIME), ";
    $sql .= "APPROVED_BY = '{$_SESSION['UID']}' WHERE TID = '$tid' ";
    $sql .= "AND PID = '$pid'";

    if (!$db->query($sql)) return false;

    post_delete_tags($tid, $pid);

    return true;
}

function post_edit_refuse($tid, $pid)
{
    html_draw_error(gettext("You are not permitted to edit this message."), 'discussion.php', 'get', array('back' => gettext("Back")), array('msg' => "$tid.$pid"));
}

function post_set_user_rating($tid, $pid, $uid, $rating)
{
    if (!is_numeric($tid)) return false;
    if (!is_numeric($pid)) return false;
    if (!is_numeric($uid)) return false;

    if (!in_array($rating, range(-1, 1))) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!$db = db::get()) return false;

    $current_datetime = date(MYSQL_DATETIME, time());

    $sql = "REPLACE INTO `{$table_prefix}POST_RATING` (TID, PID, UID, RATING, CREATED) ";
    $sql .= "SELECT POST.TID, POST.PID, USER.UID, IF(COALESCE(POST_RATING.RATING, 0) = $rating, 0, $rating) AS RATING, ";
    $sql .= "CAST('$current_datetime' AS DATETIME) FROM `{$table_prefix}POST` POST ";
    $sql .= "INNER JOIN USER ON (USER.UID = $uid) LEFT JOIN `{$table_prefix}POST_RATING` POST_RATING ";
    $sql .= "ON (POST_RATING.TID = POST.TID AND POST_RATING.PID = POST.PID AND POST_RATING.UID = $uid) ";
    $sql .= "WHERE POST.TID = $tid AND POST.PID = $pid AND POST.FROM_UID <> USER.UID";

    if (!$db->query($sql)) return false;

    return true;
}

function post_add_tags($tid, $pid, array $tags)
{
    if (!is_numeric($tid)) return false;
    if (!is_numeric($pid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!$db = db::get()) return false;

    $tags = $db->escape($tags);

    foreach ($tags as $tag) {

        $sql = "INSERT IGNORE INTO `{$table_prefix}TAG` (TAG) VALUES ('$tag')";
        if (!$db->query($sql)) return false;
    }

    $tags = implode("','", $tags);

    $sql = "INSERT IGNORE INTO `{$table_prefix}POST_TAG` (TID, PID, TAG) ";
    $sql .= "SELECT '$tid', '$pid', TAG.TID FROM `{$table_prefix}TAG` TAG ";
    $sql .= "WHERE TAG.TAG IN ('$tags')";

    if (!$db->query($sql)) return false;

    return true;
}

function post_delete_tags($tid, $pid)
{
    if (!is_numeric($tid)) return false;
    if (!is_numeric($pid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!$db = db::get()) return false;

    $sql = "DELETE FROM `{$table_prefix}POST_TAG` WHERE TID = '$tid' AND PID = '$pid'";

    if (!$db->query($sql)) return false;

    return true;
}

class MessageTextParse
{
    protected $message;

    protected $sig;

    protected $original;

    public function __construct($message)
    {
        $this->original = $message;

        $message_parts = preg_split('/(<[^<>]+>)/u', $message, -1, PREG_SPLIT_DELIM_CAPTURE);

        $signature_parts = array();

        if (($signature_offset = array_search("<div class=\"sig\">", $message_parts)) !== false) {

            while (sizeof($message_parts) > 0) {

                $signature_parts = array_merge($signature_parts, array_splice($message_parts, $signature_offset, 1));
                if (count(explode('<div', implode('', $signature_parts))) == count(explode('</div>', implode('', $signature_parts)))) break;
            }
        }

        $signature = preg_replace('/^<div class="sig">(.*)<\/div>$/Dsu', '$1', implode('', $signature_parts));

        $message = implode('', $message_parts);

        $this->message = fix_html($message);

        $this->sig = fix_html($signature);
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getSig()
    {
        return $this->sig;
    }

    public function getOriginal()
    {
        return $this->original;
    }
}