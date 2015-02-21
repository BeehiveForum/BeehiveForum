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
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'forum.inc.php';
require_once BH_INCLUDE_PATH . 'ip.inc.php';
require_once BH_INCLUDE_PATH . 'timezone.inc.php';
// End Required includes

/**
 * @return bool|number
 */
function user_count()
{
    if (!$db = db::get()) return false;

    $sql = "SELECT COUNT(UID) AS COUNT FROM USER";

    if (!($result = $db->query($sql))) return false;

    list($user_count) = $result->fetch_row();

    return $user_count;
}

function user_exists($logon, $check_uid = false)
{
    if (!$db = db::get()) return false;

    $logon = $db->escape($logon);

    if (is_numeric($check_uid) && $check_uid !== false) {

        $sql = "SELECT COUNT(UID) AS USER_COUNT FROM USER ";
        $sql .= "WHERE LOGON = '$logon' AND UID <> '$check_uid'";

    } else {

        $sql = "SELECT COUNT(UID) AS USER_COUNT FROM USER ";
        $sql .= "WHERE LOGON = '$logon'";
    }

    if (!($result = $db->query($sql))) return false;

    list($user_count) = $result->fetch_row();

    return ($user_count > 0);
}

function user_create($logon, $password, $nickname, $email)
{
    if (!$db = db::get()) return false;

    $ipaddress = get_ip_address();

    $logon = $db->escape($logon);
    $nickname = $db->escape($nickname);
    $email = $db->escape($email);

    if (isset($_SESSION['REFERER']) && strlen(trim($_SESSION['REFERER'])) > 0) {
        $http_referer = $db->escape($_SESSION['REFERER']);
    } else {
        $http_referer = "";
    }

    $salt = user_password_salt();

    $passhash = user_password_encrypt($password, $salt);

    $current_datetime = date(MYSQL_DATETIME, time());

    $sql = "INSERT INTO USER (LOGON, PASSWD, SALT, NICKNAME, EMAIL, REGISTERED, REFERER, IPADDRESS) ";
    $sql .= "VALUES ('$logon', '$passhash', '$salt', '$nickname', '$email', CAST('$current_datetime' AS DATETIME), ";
    $sql .= "'$http_referer', '$ipaddress')";

    if (($db->query($sql))) {

        $new_uid = $db->insert_id;
        return $new_uid;
    }

    return false;
}

function user_update($uid, $logon, $nickname, $email)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    $logon = $db->escape($logon);

    $nickname = $db->escape($nickname);

    $email = $db->escape($email);

    $current_datetime = date(MYSQL_DATETIME, time());

    // Check to see if we need to save the current
    // details to the USER_HISTORY table.
    $sql = "SELECT LOGON, NICKNAME, EMAIL FROM USER_HISTORY ";
    $sql .= "WHERE UID = '$uid' ORDER BY MODIFIED DESC ";
    $sql .= "LIMIT 0, 1";

    if (!($result = $db->query($sql))) return false;

    // If there is some existing data we need to retrieve the
    // data and compare it to the new details.
    if ($result->num_rows > 0) {

        // Get the old data from the database and escape it so the strcmp works.
        $user_history_array = array_map(array($db, 'escape'), $result->fetch_assoc());

        // Check the data against that passed to the function.
        if ((strcmp($user_history_array['LOGON'], $logon) <> 0) || (strcmp($user_history_array['NICKNAME'], $nickname) <> 0) || (strcmp($user_history_array['EMAIL'], $email) <> 0)) {

            // If there are any differences we need to save the changes.
            // We save everything so that future changes don't cause
            // additional matches (NULL != $logon, etc.)
            $sql = "INSERT INTO USER_HISTORY (UID, LOGON, NICKNAME, EMAIL, MODIFIED) ";
            $sql .= "VALUES ('$uid', '$logon', '$nickname', '$email', CAST('$current_datetime' AS DATETIME))";

            if (!$db->query($sql)) return false;
        }

    } else {

        // No previous data so we just save what we have.
        $sql = "INSERT INTO USER_HISTORY (UID, LOGON, NICKNAME, EMAIL, MODIFIED) ";
        $sql .= "VALUES ('$uid', '$logon', '$nickname', '$email', CAST('$current_datetime' AS DATETIME))";

        if (!$db->query($sql)) return false;
    }

    // Update the user details
    $sql = "UPDATE LOW_PRIORITY USER SET LOGON = '$logon', NICKNAME = '$nickname', ";
    $sql .= "EMAIL = '$email' WHERE UID = '$uid'";

    if (!$db->query($sql)) return false;

    return true;
}

function user_update_nickname($uid, $nickname)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    $nickname = $db->escape($nickname);

    $sql = "UPDATE LOW_PRIORITY USER SET NICKNAME = '$nickname' ";
    $sql .= "WHERE UID = '$uid'";

    if (!$db->query($sql)) return false;

    return true;
}

function user_change_logon($uid, $logon)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    $logon = $db->escape($logon);

    $sql = "UPDATE LOW_PRIORITY USER SET LOGON = '$logon' ";
    $sql .= "WHERE UID = '$uid'";

    if (!$db->query($sql)) return false;

    return true;
}

function user_increment_post_count($uid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "UPDATE LOW_PRIORITY `{$table_prefix}USER_TRACK` ";
    $sql .= "SET USER_VALUE = USER_VALUE + 1 WHERE UID = '$uid' ";
    $sql .= "AND USER_KEY = 'POST_COUNT'";

    if (!$db->query($sql)) return false;

    return true;
}

function user_update_post_count($uid, $post_count)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;
    if (!is_numeric($post_count)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "UPDATE LOW_PRIORITY `{$table_prefix}USER_TRACK` ";
    $sql .= "SET USER_VALUE = '$post_count' WHERE UID = '$uid' ";
    $sql .= "AND USER_KEY = 'POST_COUNT'";

    if (!$db->query($sql)) return false;

    return true;
}

function user_reset_post_count($uid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "UPDATE LOW_PRIORITY `{$table_prefix}USER_TRACK` ";
    $sql .= "SET USER_VALUE = NULL WHERE UID = '$uid' ";
    $sql .= "AND USER_KEY = 'POST_COUNT'";

    if (!$db->query($sql)) return false;

    return true;
}

function user_change_password($uid, $new_password, $old_password)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    $sql = "SELECT PASSWD, SALT FROM USER WHERE UID = '$uid'";

    if (!($result = $db->query($sql))) return false;

    list($passhash, $salt) = $result->fetch_row();

    if ((md5($old_password) == $passhash) && (strlen(trim($salt))) == 0) {
        return user_reset_password($uid, $new_password, $passhash);
    }

    if (user_password_encrypt($old_password, $salt) != $passhash) return false;

    $salt = user_password_salt();

    $passhash = user_password_encrypt($new_password, $salt);

    $salt = $db->escape($salt);

    $passhash = $db->escape($passhash);

    $sql = "UPDATE USER SET PASSWD = '$passhash', ";
    $sql .= "SALT = '$salt' WHERE UID = '$uid'";

    if (!$db->query($sql)) return false;

    return true;
}

function user_reset_password($uid, $new_password, $old_passhash)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    $old_passhash = $db->escape($old_passhash);

    $salt = user_password_salt();

    $passhash = user_password_encrypt($new_password, $salt);

    $salt = $db->escape($salt);

    $passhash = $db->escape($passhash);

    $sql = "UPDATE USER SET PASSWD = '$passhash', SALT = '$salt' ";
    $sql .= "WHERE UID = '$uid' AND PASSWD = '$old_passhash'";

    if (!($db->query($sql))) return false;

    return true;
}

function user_update_forums($uid, $forum_fid, $allowed)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;
    if (!is_numeric($forum_fid)) return false;
    if (!is_numeric($allowed)) return false;

    $sql = "INSERT INTO USER_FORUM (UID, FID, ALLOWED) ";
    $sql .= "VALUES ('$uid', '$forum_fid', '$allowed') ";
    $sql .= "ON DUPLICATE KEY UPDATE ALLOWED = VALUES(ALLOWED)";

    if (!$db->query($sql)) return false;

    return true;
}

function user_logon($logon, $password)
{
    if (!$db = db::get()) return false;

    $logon = $db->escape(mb_strtoupper($logon));

    $email = $db->escape($logon);

    $ipaddress = get_ip_address();

    $ipaddress = $db->escape($ipaddress);

    $sql = "SELECT UID, PASSWD, SALT FROM USER WHERE LOGON = '$logon' OR EMAIL = '$email'";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    list($uid, $passhash, $salt) = $result->fetch_row();

    if ((md5($password) == $passhash) && (strlen(trim($salt))) == 0) {

        if (!user_reset_password($uid, $password, $passhash)) return false;

        return $uid;
    }

    if (user_password_encrypt($password, $salt) != $passhash) return false;

    $sql = "UPDATE LOW_PRIORITY USER SET IPADDRESS = '$ipaddress' WHERE UID = '$uid'";

    if (!($result = $db->query($sql))) return false;

    user_prune_expired_tokens($uid);

    return $uid;
}

function user_logon_token($logon, $token)
{
    if (!$db = db::get()) return false;

    $ipaddress = get_ip_address();

    if (!is_md5($token)) return false;

    $logon = $db->escape(mb_strtoupper($logon));

    $token = $db->escape($token);

    $ipaddress = $db->escape($ipaddress);

    $current_datetime = date(MYSQL_DATETIME, time());

    $sql = "SELECT USER.UID FROM USER INNER JOIN USER_TOKEN ON (USER_TOKEN.UID = USER.UID) ";
    $sql .= "WHERE USER.LOGON = '$logon' AND USER_TOKEN.TOKEN = '$token' ";
    $sql .= "AND USER_TOKEN.EXPIRES > '$current_datetime'";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    list($uid) = $result->fetch_row();

    $sql = "UPDATE USER SET IPADDRESS = '$ipaddress' WHERE UID = '$uid'";

    if (!($result = $db->query($sql))) return false;

    if (!user_renew_token($uid, $token)) return false;

    user_prune_expired_tokens($uid);

    return $uid;
}

function user_generate_token($uid)
{
    if (!is_numeric($uid)) return false;

    if (!$db = db::get()) return false;

    user_prune_expired_tokens($uid);

    $token = md5(uniqid(mt_rand()));

    $current_datetime = date(MYSQL_DATETIME, time());

    $sql = "INSERT INTO USER_TOKEN (UID, TOKEN, EXPIRES) VALUES ('$uid', ";
    $sql .= "'$token',  DATE_ADD('$current_datetime', INTERVAL 1 MONTH))";

    if (!($db->query($sql))) return false;

    return $token;
}

function user_prune_expired_tokens($uid)
{
    if (!is_numeric($uid)) return false;

    if (!$db = db::get()) return false;

    $current_datetime = date(MYSQL_DATETIME, time());

    $sql = "DELETE QUICK FROM USER_TOKEN WHERE UID = '$uid' ";
    $sql .= "AND EXPIRES < '$current_datetime'";

    if (!($db->query($sql))) return false;

    return true;
}

function user_renew_token($uid, $token)
{
    if (!is_numeric($uid)) return false;

    if (!$db = db::get()) return false;

    $token = $db->escape($token);

    $current_datetime = date(MYSQL_DATETIME, time());

    $sql = "UPDATE USER_TOKEN SET EXPIRES = DATE_ADD('$current_datetime', INTERVAL 1 MONTH) ";
    $sql .= "WHERE UID = '$uid' AND TOKEN = '$token'";

    if (!($db->query($sql))) return false;

    user_prune_expired_tokens($uid);

    return true;
}

function user_password_salt()
{
    return substr(str_replace('+', '.', base64_encode(pack('N4', mt_rand(), mt_rand(), mt_rand(), mt_rand()))), 0, 22);
}

function user_password_encrypt($password, $salt)
{
    return crypt($password, $salt);
}

function user_get($uid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    if ((!$table_prefix = get_table_prefix()) || ($uid == $_SESSION['UID']) || ($uid == 0)) {

        $sql = "SELECT USER.UID, USER.LOGON, USER.PASSWD, USER.SALT, USER.NICKNAME, ";
        $sql .= "USER.EMAIL, UNIX_TIMESTAMP(USER.REGISTERED) AS REGISTERED, ";
        $sql .= "USER.IPADDRESS, USER.REFERER, USER.APPROVED FROM USER ";
        $sql .= "WHERE USER.UID = '$uid'";

    } else {

        $sql = "SELECT USER.UID, USER.LOGON, USER.PASSWD, USER.SALT, ";
        $sql .= "COALESCE(USER_PEER.PEER_NICKNAME, USER.NICKNAME) AS NICKNAME, ";
        $sql .= "USER.EMAIL, UNIX_TIMESTAMP(USER.REGISTERED) AS REGISTERED, ";
        $sql .= "USER.IPADDRESS, USER.REFERER, USER.APPROVED FROM USER ";
        $sql .= "LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ";
        $sql .= "ON (USER_PEER.PEER_UID = USER.UID AND USER_PEER.UID = '{$_SESSION['UID']}') ";
        $sql .= "WHERE USER.UID = '$uid'";
    }

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $user_get = $result->fetch_assoc();

    if (isset($user_get['PEER_NICKNAME'])) {

        if (!is_null($user_get['PEER_NICKNAME']) && strlen($user_get['PEER_NICKNAME']) > 0) {
            $user_get['NICKNAME'] = $user_get['PEER_NICKNAME'];
        }
    }

    return $user_get;
}

function user_get_by_passhash($uid, $passhash)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    $passhash = $db->escape($passhash);

    $sql = "SELECT UID, LOGON, PASSWD, NICKNAME, EMAIL, REGISTERED, ";
    $sql .= "IPADDRESS, REFERER, APPROVED FROM USER WHERE UID = '$uid' ";
    $sql .= "AND PASSWD = '$passhash'";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $user_get = $result->fetch_assoc();

    return $user_get;
}

function user_get_logon($uid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    $sql = "SELECT LOGON FROM USER WHERE UID = '$uid'";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    list($logon) = $result->fetch_row();

    return $logon;
}

function user_get_nickname($uid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    $sql = "SELECT NICKNAME FROM USER WHERE UID = '$uid'";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    list($nickname) = $result->fetch_row();

    return $nickname;
}

function user_get_email($uid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    $sql = "SELECT EMAIL FROM USER WHERE UID = '$uid'";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    list($email) = $result->fetch_row();

    return $email;
}

function user_get_referer($uid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    $sql = "SELECT REFERER FROM USER WHERE UID = '$uid'";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    list($referer) = $result->fetch_row();

    return $referer;
}

function user_get_passwd($uid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    $sql = "SELECT PASSWD FROM USER WHERE UID = '$uid'";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    list($passwd) = $result->fetch_row();

    return $passwd;
}

function user_get_by_logon($logon)
{
    if (!$db = db::get()) return false;

    $logon = $db->escape($logon);

    $sql = "SELECT UID, LOGON, PASSWD, NICKNAME, EMAIL, ";
    $sql .= "REGISTERED, IPADDRESS, REFERER, APPROVED ";
    $sql .= "FROM USER WHERE LOGON LIKE '$logon'";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $user_array = $result->fetch_assoc();

    return $user_array;
}

function user_get_logon_callback($user)
{
    return $user['LOGON'];
}

function user_get_sig($uid)
{
    if (!$db = db::get()) return '';

    if (!is_numeric($uid)) return '';

    if (!($table_prefix = get_table_prefix())) return '';

    $sql = "SELECT CONTENT FROM `{$table_prefix}USER_SIG` WHERE UID = '$uid'";

    if (!($result = $db->query($sql))) return '';

    if ($result->num_rows == 0) return '';

    list($content) = $result->fetch_row();

    return $content;
}

function user_get_last_ip_address($uid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    $sql = "SELECT IPADDRESS FROM USER WHERE UID = '$uid'";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    list($ipaddress) = $result->fetch_row();

    return $ipaddress;
}

function user_get_pref_names($exclude = array())
{
    $pref_names = array();

    if (!$db = db::get()) return $pref_names;

    if (!($table_prefix = get_table_prefix())) return $pref_names;

    $sql = "SHOW COLUMNS FROM USER_PREFS WHERE Field <> 'UID' ";

    if (is_array($exclude) && sizeof($exclude) > 0) {

        $exclude_list = implode("', '", array_map(array($db, 'escape'), $exclude));
        $sql .= "AND Field NOT IN ('$exclude_list')";
    }

    if (!($result = $db->query($sql))) return $pref_names;

    while (($column_data = $result->fetch_assoc()) !== null) {
        $pref_names[$column_data['Field']] = null;
    }

    return $pref_names;
}

function user_get_prefs($uid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    // Arrays to hold the user preferences.
    $global_prefs_array = array();
    $forum_prefs_array = array();

    // 2. The user's global prefs, in USER_PREFS:
    $sql = "SELECT USER_PREFS.FIRSTNAME, USER_PREFS.LASTNAME, USER_PREFS.DOB, ";
    $sql .= "USER_PREFS.HOMEPAGE_URL, USER_PREFS.PIC_URL, USER_PREFS.EMAIL_NOTIFY, ";
    $sql .= "USER_PREFS.TIMEZONE, USER_PREFS.DL_SAVING, USER_PREFS.MARK_AS_OF_INT, ";
    $sql .= "USER_PREFS.POSTS_PER_PAGE, USER_PREFS.FONT_SIZE, USER_PREFS.STYLE, ";
    $sql .= "USER_PREFS.EMOTICONS, USER_PREFS.VIEW_SIGS, USER_PREFS.START_PAGE, ";
    $sql .= "USER_PREFS.LANGUAGE, USER_PREFS.PM_NOTIFY, USER_PREFS.PM_NOTIFY_EMAIL, ";
    $sql .= "USER_PREFS.PM_SAVE_SENT_ITEM, USER_PREFS.PM_INCLUDE_REPLY, ";
    $sql .= "USER_PREFS.PM_AUTO_PRUNE, USER_PREFS.PM_EXPORT_TYPE, ";
    $sql .= "USER_PREFS.PM_EXPORT_FILE, USER_PREFS.PM_EXPORT_ATTACHMENTS, ";
    $sql .= "USER_PREFS.PM_EXPORT_WORDFILTER, USER_PREFS.DOB_DISPLAY, USER_PREFS.ANON_LOGON, ";
    $sql .= "USER_PREFS.SHOW_STATS, USER_PREFS.IMAGES_TO_LINKS, USER_PREFS.USE_WORD_FILTER, ";
    $sql .= "USER_PREFS.USE_ADMIN_FILTER, USER_PREFS.ALLOW_EMAIL, USER_PREFS.USE_EMAIL_ADDR, ";
    $sql .= "USER_PREFS.ALLOW_PM, USER_PREFS.POST_PAGE, USER_PREFS.SHOW_THUMBS, ";
    $sql .= "USER_PREFS.ENABLE_WIKI_WORDS, USER_PREFS.ENABLE_WIKI_QUICK_LINKS, ";
    $sql .= "USER_PREFS.USE_MOVER_SPOILER, USER_PREFS.USE_LIGHT_MODE_SPOILER, ";
    $sql .= "USER_PREFS.USE_OVERFLOW_RESIZE, USER_PREFS.PIC_AID, USER_PREFS.AVATAR_URL, ";
    $sql .= "USER_PREFS.AVATAR_AID, USER_PREFS.REPLY_QUICK, USER_PREFS.THREADS_BY_FOLDER, ";
    $sql .= "USER_PREFS.THREAD_LAST_PAGE, USER_PREFS.LEFT_FRAME_WIDTH, USER_PREFS.SHOW_AVATARS, ";
    $sql .= "USER_PREFS.SHOW_SHARE_LINKS, USER_PREFS.ENABLE_TAGS, USER_PREFS.AUTO_SCROLL_MESSAGES, ";
    $sql .= "TIMEZONES.GMT_OFFSET, TIMEZONES.DST_OFFSET FROM USER_PREFS ";
    $sql .= "LEFT JOIN TIMEZONES ON (TIMEZONES.TZID = USER_PREFS.TIMEZONE) ";
    $sql .= "WHERE USER_PREFS.UID = '$uid'";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows > 0) {
        $global_prefs_array = $result->fetch_assoc();
    }

    // 3. The user's per-forum prefs, in GLOBAL USER_PREFS (not all prefs are set here e.g. name):
    if (($table_prefix = get_table_prefix()) !== false) {

        $sql = "SELECT HOMEPAGE_URL, PIC_URL, EMAIL_NOTIFY, MARK_AS_OF_INT, POSTS_PER_PAGE, ";
        $sql .= "FONT_SIZE, STYLE, EMOTICONS, VIEW_SIGS, START_PAGE, LANGUAGE, SHOW_STATS, ";
        $sql .= "IMAGES_TO_LINKS, USE_WORD_FILTER, USE_ADMIN_FILTER, SHOW_THUMBS, ENABLE_WIKI_WORDS, ";
        $sql .= "ENABLE_WIKI_QUICK_LINKS, USE_MOVER_SPOILER, USE_LIGHT_MODE_SPOILER, USE_OVERFLOW_RESIZE, ";
        $sql .= "PIC_AID, AVATAR_URL, AVATAR_AID, REPLY_QUICK, THREADS_BY_FOLDER, THREAD_LAST_PAGE, ";
        $sql .= "LEFT_FRAME_WIDTH, SHOW_AVATARS, SHOW_SHARE_LINKS, ENABLE_TAGS, AUTO_SCROLL_MESSAGES ";
        $sql .= "FROM `{$table_prefix}USER_PREFS` WHERE UID = '$uid'";

        if (!($result = $db->query($sql))) return false;

        if ($result->num_rows > 0) {
            $forum_prefs_array = $result->fetch_assoc();
        }
    }

    // Prune empty values from the forum_prefs array to stop them overwriting valid global prefs
    $forum_prefs_array = array_filter($forum_prefs_array, "strlen");

    // Get the array keys.
    $global_prefs_array_keys = array_keys($global_prefs_array);
    $forum_prefs_array_keys = array_keys($forum_prefs_array);

    // Add keys to indicate whether the preference is set globally or not
    foreach ($forum_prefs_array_keys as $key) {
        $forum_prefs_array[$key . '_GLOBAL'] = false;
    }

    foreach ($global_prefs_array_keys as $key) {
        $global_prefs_array[$key . '_GLOBAL'] = true;
    }

    // Merge them all together, with forum prefs overriding global prefs
    return array_merge($global_prefs_array, $forum_prefs_array);
}

function user_update_prefs($uid, array $prefs, array $prefs_global = array())
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    if (!is_array($prefs)) return false;

    // Check that $prefs_global_setting_array is an array
    if (!is_array($prefs_global)) {
        $prefs_global = array();
    }

    // Arrays to hold preferences
    $global_prefs_array = array();
    $forum_prefs_array = array();

    // names of preferences that can be set globally
    $global_pref_names = array(
        'FIRSTNAME',
        'LASTNAME',
        'DOB',
        'HOMEPAGE_URL',
        'PIC_URL',
        'EMAIL_NOTIFY',
        'TIMEZONE',
        'DL_SAVING',
        'MARK_AS_OF_INT',
        'POSTS_PER_PAGE',
        'FONT_SIZE',
        'STYLE',
        'EMOTICONS',
        'VIEW_SIGS',
        'START_PAGE',
        'LANGUAGE',
        'PM_NOTIFY',
        'PM_NOTIFY_EMAIL',
        'PM_SAVE_SENT_ITEM',
        'PM_INCLUDE_REPLY',
        'PM_AUTO_PRUNE',
        'PM_EXPORT_TYPE',
        'PM_EXPORT_FILE',
        'PM_EXPORT_ATTACHMENTS',
        'PM_EXPORT_WORDFILTER',
        'DOB_DISPLAY',
        'ANON_LOGON',
        'SHOW_STATS',
        'IMAGES_TO_LINKS',
        'USE_WORD_FILTER',
        'USE_ADMIN_FILTER',
        'ALLOW_EMAIL',
        'USE_EMAIL_ADDR',
        'ALLOW_PM',
        'POST_PAGE',
        'SHOW_THUMBS',
        'ENABLE_WIKI_WORDS',
        'ENABLE_WIKI_QUICK_LINKS',
        'ENABLE_TAGS',
        'AUTO_SCROLL_MESSAGES',
        'USE_MOVER_SPOILER',
        'USE_LIGHT_MODE_SPOILER',
        'USE_OVERFLOW_RESIZE',
        'PIC_AID',
        'AVATAR_URL',
        'AVATAR_AID',
        'REPLY_QUICK',
        'THREADS_BY_FOLDER',
        'THREAD_LAST_PAGE',
        'LEFT_FRAME_WIDTH',
        'SHOW_AVATARS',
        'SHOW_SHARE_LINKS',
    );

    // names of preferences that can be set on a per-forum basis
    $forum_pref_names = array(
        'HOMEPAGE_URL',
        'PIC_URL',
        'EMAIL_NOTIFY',
        'MARK_AS_OF_INT',
        'POSTS_PER_PAGE',
        'FONT_SIZE',
        'STYLE',
        'EMOTICONS',
        'VIEW_SIGS',
        'START_PAGE',
        'LANGUAGE',
        'SHOW_STATS',
        'IMAGES_TO_LINKS',
        'USE_WORD_FILTER',
        'USE_ADMIN_FILTER',
        'SHOW_THUMBS',
        'ENABLE_WIKI_WORDS',
        'ENABLE_WIKI_QUICK_LINKS',
        'ENABLE_TAGS',
        'AUTO_SCROLL_MESSAGES',
        'USE_MOVER_SPOILER',
        'USE_LIGHT_MODE_SPOILER',
        'USE_OVERFLOW_RESIZE',
        'PIC_AID',
        'AVATAR_URL',
        'AVATAR_AID',
        'REPLY_QUICK',
        'THREADS_BY_FOLDER',
        'THREAD_LAST_PAGE',
        'LEFT_FRAME_WIDTH',
        'SHOW_AVATARS',
        'SHOW_SHARE_LINKS',
    );

    // Loop through the passed preference names and check they're valid
    // and whether the value needs to go in the global or forum USER_PREFS
    // table. If the preference is a global only preference it goes into
    // global USER_PREFS table regardless, otherwise the preference will
    // be checked against to see if the user wants it setting globally
    // or only on the current forum.
    foreach ($prefs as $pref_name => $pref_setting) {

        if (!user_check_pref($pref_name, $pref_setting)) {
            continue;
        }

        if (in_array($pref_name, $global_pref_names) && !in_array($pref_name, $forum_pref_names)) {

            $global_prefs_array[$pref_name] = $pref_setting;

        } else if (in_array($pref_name, $global_pref_names) && isset($prefs_global[$pref_name]) && ($prefs_global[$pref_name] == true)) {

            $global_prefs_array[$pref_name] = $pref_setting;

        } else if (in_array($pref_name, $forum_pref_names)) {

            $forum_prefs_array[$pref_name] = $pref_setting;
        }
    }

    // Check to see we have some preferences to set globally.
    if (sizeof($global_prefs_array) > 0) {

        // Concat the column names together, escaping them and enclosing them in backticks.
        $column_names = implode("`, `", array_map(array($db, 'escape'), array_keys($global_prefs_array)));

        // Concat the values together, escaping them and enclosing them in quotes.
        $column_insert_values = implode("', '", array_map(array($db, 'escape'), array_values($global_prefs_array)));

        // Concat the column names together, pass them through user_update_prefs_callback
        // which constructs a valid ON DUPLICATE KEY UPDATE statement for the INSERT.
        $column_update_values = implode(", ", array_map('user_update_prefs_callback_insert', array_keys($global_prefs_array)));

        // Construct the query and run it.
        $sql = "INSERT INTO USER_PREFS (`UID`, `$column_names`) VALUES('$uid', '$column_insert_values') ";
        $sql .= "ON DUPLICATE KEY UPDATE $column_update_values ";

        if (!$db->query($sql)) return false;

        // If a pref is set globally, we need to remove it from all the
        // per-forum USER_PREFS tables. We use array_intersect to find
        // out which columns we need to update.
        $update_prefs_array = array_intersect($forum_pref_names, array_keys($global_prefs_array));

        // Only proceed if we have something to process.
        if (sizeof($update_prefs_array) > 0) {

            if (!$forum_prefix_array = forum_get_all_prefixes()) return false;

            foreach ($forum_prefix_array as $forum_prefix) {

                $update_prefs_sql = implode(", ", array_map('user_update_prefs_callback_update', $update_prefs_array));

                $sql = "UPDATE LOW_PRIORITY `{$forum_prefix}USER_PREFS` SET $update_prefs_sql WHERE UID = '$uid'";

                if (!$db->query($sql)) return false;
            }
        }
    }

    if ((sizeof($forum_prefs_array) > 0) && ($table_prefix = get_table_prefix())) {

        // Concat the column names together, escaping them and enclosing them in backticks.
        $column_names = implode("`, `", array_map(array($db, 'escape'), array_keys($forum_prefs_array)));

        // Concat the values together, escaping them and enclosing them in quotes.
        $column_insert_values = implode("', '", array_map(array($db, 'escape'), array_values($forum_prefs_array)));

        // Concat the column names together, pass them through user_update_prefs_callback
        // which constructs a valid ON DUPLICATE KEY UPDATE statement for the INSERT.
        $column_update_values = implode(", ", array_map('user_update_prefs_callback_insert', array_keys($forum_prefs_array)));

        // Construct the query and run it.
        $sql = "INSERT INTO `{$table_prefix}USER_PREFS` (`UID`, `$column_names`) ";
        $sql .= "VALUES('$uid', '$column_insert_values') ON DUPLICATE KEY UPDATE $column_update_values ";

        if (!$db->query($sql)) return false;
    }

    return true;
}

function user_update_prefs_callback_insert($column)
{
    return sprintf('%s = VALUES(%s)', $column, $column);
}

function user_update_prefs_callback_update($column)
{
    return sprintf("%s = NULL", $column);
}

function user_check_pref($name, $value)
{
    // Checks to ensure that a preference setting contains valid data
    if (strlen(trim($value)) == 0) return true;

    // Different cases for different fields
    switch ($name) {

        case "FIRSTNAME":
        case "LASTNAME":

            return preg_match("/^[a-z0-9 ]*$/Diu", $value);
            break;

        case "STYLE":
        case "EMOTICONS":
        case "LANGUAGE":

            return preg_match("/^[a-z0-9_-]*$/Diu", $value);
            break;

        case "DOB":

            return preg_match("/^[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}$/Du", $value);
            break;

        case "HOMEPAGE_URL":
        case "PIC_URL":
        case "AVATAR_URL":

            return empty($value) || filter_var($value, FILTER_VALIDATE_URL);
            break;

        case "EMAIL_NOTIFY":
        case "DL_SAVING":
        case "MARK_AS_OF_INT":
        case "VIEW_SIGS":
        case "PM_NOTIFY":
        case "PM_NOTIFY_EMAIL":
        case "PM_INCLUDE_REPLY":
        case "PM_SAVE_SENT_ITEM":
        case "PM_EXPORT_ATTACHMENTS":
        case "PM_EXPORT_WORDFILTER":
        case "IMAGES_TO_LINKS":
        case "SHOW_STATS":
        case "USE_WORD_FILTER":
        case "USE_ADMIN_FILTER":
        case "ALLOW_EMAIL":
        case "USE_EMAIL_ADDR":
        case "ALLOW_PM":
        case "ENABLE_WIKI_WORDS":
        case "ENABLE_WIKI_QUICK_LINKS":
        case "ENABLE_TAGS":
        case "AUTO_SCROLL_MESSAGES":
        case "USE_MOVER_SPOILER":
        case "USE_LIGHT_MODE_SPOILER":
        case "USE_OVERFLOW_RESIZE":
        case "REPLY_QUICK":
        case "THREADS_BY_FOLDER":
        case "THREAD_LAST_PAGE":
        case "SHOW_AVATARS":
        case "SHOW_SHARE_LINKS":

            return ($value == "Y" || $value == "N") ? true : false;
            break;

        case "PIC_AID":
        case "AVATAR_AID":
        case "ANON_LOGON":
        case "TIMEZONE":
        case "POSTS_PER_PAGE":
        case "FONT_SIZE":
        case "START_PAGE":
        case "DOB_DISPLAY":
        case "POST_PAGE":
        case "SHOW_THUMBS":
        case "PM_AUTO_PRUNE":
        case "PM_EXPORT_FILE":
        case "PM_EXPORT_TYPE":
        case "LEFT_FRAME_WIDTH":

            return is_numeric($value);
            break;

        default:

            return false;
            break;
    }
}

function user_update_sig($uid, $content, $global_update = false)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    $content = $db->escape($content);

    if ($global_update === true) {

        if (!$forum_prefix_array = forum_get_all_prefixes()) return false;

        foreach ($forum_prefix_array as $forum_prefix) {

            $sql = "INSERT INTO `{$forum_prefix}USER_SIG` (UID, CONTENT) ";
            $sql .= "VALUES ('$uid', '$content') ON DUPLICATE KEY ";
            $sql .= "UPDATE CONTENT = VALUES(CONTENT)";

            if (!$db->query($sql)) return false;
        }

    } else {

        if (!($table_prefix = get_table_prefix())) return false;

        $sql = "INSERT INTO `{$table_prefix}USER_SIG` (UID, CONTENT) ";
        $sql .= "VALUES ('$uid', '$content') ON DUPLICATE KEY UPDATE ";
        $sql .= "CONTENT = VALUES(CONTENT)";

        if (!$db->query($sql)) return false;
    }

    return true;
}

function user_guest_enabled()
{
    if (forum_get_setting('guest_account_enabled', 'N')) {
        return false;
    }

    return true;
}

function user_get_todays_birthdays()
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    // Constants for user relationship
    $user_ignored = USER_IGNORED;
    $user_ignored_completely = USER_IGNORED_COMPLETELY;

    $sql = "SELECT USER.UID, USER.LOGON, USER.NICKNAME, USER_PEER2.PEER_NICKNAME, ";
    $sql .= "USER_PEER.RELATIONSHIP AS PEER_RELATIONSHIP, USER_PEER2.RELATIONSHIP AS USER_RELATIONSHIP, ";
    $sql .= "USER_PREFS_FORUM.AVATAR_URL AS AVATAR_URL_FORUM, USER_PREFS_FORUM.AVATAR_AID AS AVATAR_AID_FORUM, ";
    $sql .= "USER_PREFS_GLOBAL.AVATAR_URL AS AVATAR_URL_GLOBAL, USER_PREFS_GLOBAL.AVATAR_AID AS AVATAR_AID_GLOBAL ";
    $sql .= "FROM USER USER LEFT JOIN USER_PREFS USER_PREFS_GLOBAL ON (USER_PREFS_GLOBAL.UID = USER.UID) ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_PREFS` USER_PREFS_FORUM ON (USER_PREFS_FORUM.UID = USER.UID) ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ON (USER_PEER.UID = USER.UID ";
    $sql .= "AND USER_PEER.PEER_UID = '{$_SESSION['UID']}') LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER2 ";
    $sql .= "ON (USER_PEER2.PEER_UID = USER.UID AND USER_PEER2.UID = '{$_SESSION['UID']}') ";
    $sql .= "WHERE USER_PREFS_GLOBAL.DOB > 0 AND USER_PREFS_GLOBAL.DOB_DISPLAY > 1 ";
    $sql .= "AND DATE_FORMAT(USER_PREFS_GLOBAL.DOB, '%m-%d') = DATE_FORMAT(UTC_TIMESTAMP(), '%m-%d') ";
    $sql .= "AND ((USER_PEER.RELATIONSHIP & $user_ignored_completely) = 0 OR USER_PEER.RELATIONSHIP IS NULL) ";
    $sql .= "AND ((USER_PEER.RELATIONSHIP & $user_ignored) = 0 OR USER_PEER.RELATIONSHIP IS NULL) ";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $user_birthdays_array = array();

    while (($user_data = $result->fetch_assoc()) !== null) {

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

        if (isset($user_data['AVATAR_URL_FORUM']) && filter_var($user_data['AVATAR_URL_FORUM'], FILTER_VALIDATE_URL)) {
            $user_data['AVATAR_URL'] = $user_data['AVATAR_URL_FORUM'];
        } else if (isset($user_data['AVATAR_URL_GLOBAL']) && filter_var($user_data['AVATAR_URL_GLOBAL'], FILTER_VALIDATE_URL)) {
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

        $user_birthdays_array[] = array(
            'UID' => $user_data['UID'],
            'LOGON' => $user_data['LOGON'],
            'NICKNAME' => $user_data['NICKNAME'],
            'RELATIONSHIP' => $user_data['USER_RELATIONSHIP'],
            'AVATAR_URL' => $user_data['AVATAR_URL'],
            'AVATAR_AID' => $user_data['AVATAR_AID'],
        );
    }

    return $user_birthdays_array;
}

function user_search_array_clean($user_search)
{
    if (!($db = db::get())) return '';

    return $db->escape(trim(str_replace("%", "", $user_search)));
}

function user_search($user_search)
{
    if (!$db = db::get()) return false;

    $user_array = array();

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    $user_search_array = preg_split('/,\s*/u', trim($user_search, ', '));
    $user_search_array = array_map('user_search_array_clean', $user_search_array);

    $user_search_logon = implode("%' OR LOGON LIKE '", $user_search_array);
    $user_search_nickname = implode("%' OR NICKNAME LIKE '", $user_search_array);

    // Include join to USER_PEER table if we have a valid forum.
    if (($table_prefix = get_table_prefix()) !== false) {

        // Main query.
        $sql = "SELECT USER.UID, USER.LOGON, USER.NICKNAME, USER_PEER.PEER_NICKNAME, ";
        $sql .= "USER_PEER.RELATIONSHIP FROM USER LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ";
        $sql .= "ON (USER_PEER.PEER_UID = USER.UID AND USER_PEER.UID = '{$_SESSION['UID']}') ";
        $sql .= "WHERE (LOGON LIKE '$user_search_logon%' ";
        $sql .= "OR NICKNAME LIKE '$user_search_nickname%') ";
        $sql .= "LIMIT 10";

    } else {

        // Main query.
        $sql = "SELECT USER.UID, USER.LOGON, USER.NICKNAME FROM USER ";
        $sql .= "WHERE (LOGON LIKE '$user_search_logon%' ";
        $sql .= "OR NICKNAME LIKE '$user_search_nickname%') ";
        $sql .= "LIMIT 10";
    }

    if (!($result = $db->query($sql))) return false;

    // Fetch the number of total results
    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!($result_count = $db->query($sql))) return false;

    list($user_count) = $result_count->fetch_row();

    // Check if we have any results.
    if ($result->num_rows == 0) return false;

    while (($user_data = $result->fetch_assoc()) !== null) {

        if (isset($user_data['LOGON']) && isset($user_data['PEER_NICKNAME'])) {
            if (!is_null($user_data['PEER_NICKNAME']) && strlen($user_data['PEER_NICKNAME']) > 0) {
                $user_data['NICKNAME'] = $user_data['PEER_NICKNAME'];
            }
        }

        if (!isset($user_data['LOGON'])) $user_data['LOGON'] = gettext("Unknown user");
        if (!isset($user_data['NICKNAME'])) $user_data['NICKNAME'] = "";

        $user_array[$user_data['UID']] = $user_data;
    }

    return array(
        'results_count' => $user_count,
        'results_array' => $user_array
    );
}

function user_get_ip_addresses($uid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $user_ip_addresses_array = array();

    // Fetch the last 20 IP addresses from the POST table
    $sql = "SELECT DISTINCT IPADDRESS FROM `{$table_prefix}POST` ";
    $sql .= "WHERE FROM_UID = '$uid' ORDER BY TID DESC LIMIT 0, 10";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    while (($user_ip_addresses_row = $result->fetch_assoc()) !== null) {

        if (strlen($user_ip_addresses_row['IPADDRESS']) > 0) {
            $user_ip_addresses_array[] = $user_ip_addresses_row['IPADDRESS'];
        }
    }

    return $user_ip_addresses_array;
}

function user_get_friends($uid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $user_rel = USER_FRIEND;

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    $sql = "SELECT USER.UID, USER.LOGON, USER.NICKNAME, USER_PEER.PEER_NICKNAME, ";
    $sql .= "USER_PEER.RELATIONSHIP FROM `{$table_prefix}USER_PEER` USER_PEER ";
    $sql .= "LEFT JOIN USER USER ON (USER.UID = USER_PEER.PEER_UID) ";
    $sql .= "LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ";
    $sql .= "ON (USER_PEER.PEER_UID = USER.UID AND USER_PEER.UID = '{$_SESSION['UID']}') ";
    $sql .= "WHERE USER.UID IS NOT NULL AND USER_PEER.UID = '$uid' ";
    $sql .= "AND (USER_PEER.RELATIONSHIP & $user_rel > 0) ";
    $sql .= "LIMIT 0, 20";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $user_get_peers_array = array();

    while (($user_data = $result->fetch_assoc()) !== null) {

        if (isset($user_data['LOGON']) && isset($user_data['PEER_NICKNAME'])) {
            if (!is_null($user_data['PEER_NICKNAME']) && strlen($user_data['PEER_NICKNAME']) > 0) {
                $user_data['NICKNAME'] = $user_data['PEER_NICKNAME'];
            }
        }

        if (!isset($user_data['LOGON'])) $user_data['LOGON'] = gettext("Unknown user");
        if (!isset($user_data['NICKNAME'])) $user_data['NICKNAME'] = "";

        $user_get_peers_array[] = $user_data;
    }

    return $user_get_peers_array;
}

function user_get_relationships($uid, $page = 1)
{
    if (!$db = db::get()) return false;

    $user_get_peers_array = array();

    if (!is_numeric($uid)) return false;

    if (!is_numeric($page) || ($page < 1)) $page = 1;

    $offset = calculate_page_offset($page, 10);

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT SQL_CALC_FOUND_ROWS USER.UID, USER.LOGON, USER.NICKNAME, ";
    $sql .= "USER_PEER.PEER_NICKNAME, USER_PEER.RELATIONSHIP, USER_PEER.PEER_NICKNAME ";
    $sql .= "FROM `{$table_prefix}USER_PEER` USER_PEER ";
    $sql .= "LEFT JOIN USER USER ON (USER.UID = USER_PEER.PEER_UID) ";
    $sql .= "WHERE USER_PEER.UID = '$uid' AND USER.UID IS NOT NULL ";
    $sql .= "LIMIT $offset, 10";

    if (!($result = $db->query($sql))) return false;

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!($result_count = $db->query($sql))) return false;

    list($user_get_peers_count) = $result_count->fetch_row();

    if (($result->num_rows == 0) && ($user_get_peers_count > 0) && ($page > 1)) {
        return user_get_relationships($uid, $page - 1);
    }

    while (($user_data = $result->fetch_assoc()) !== null) {

        if (isset($user_data['LOGON']) && isset($user_data['PEER_NICKNAME'])) {
            if (!is_null($user_data['PEER_NICKNAME']) && strlen($user_data['PEER_NICKNAME']) > 0) {
                $user_data['NICKNAME'] = $user_data['PEER_NICKNAME'];
            }
        }

        if (!isset($user_data['LOGON'])) $user_data['LOGON'] = gettext("Unknown user");
        if (!isset($user_data['NICKNAME'])) $user_data['NICKNAME'] = "";

        $user_get_peers_array[$user_data['UID']] = $user_data;
    }

    return array(
        'user_count' => $user_get_peers_count,
        'user_array' => $user_get_peers_array
    );
}

function user_get_peer_relationship($uid, $peer_uid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;
    if (!is_numeric($peer_uid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT RELATIONSHIP FROM `{$table_prefix}USER_PEER` ";
    $sql .= "WHERE UID = '$uid' AND PEER_UID = '$peer_uid'";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows > 0) {

        list($peer_relationship) = $result->fetch_row();
        return $peer_relationship;
    }

    return 0;
}

function user_get_peer_nickname($uid, $peer_uid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;
    if (!is_numeric($peer_uid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT COALESCE(USER_PEER.PEER_NICKNAME, USER.NICKNAME) AS NICKNAME ";
    $sql .= "FROM USER LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ";
    $sql .= "ON (USER_PEER.PEER_UID = USER.UID AND USER_PEER.UID = '$uid') ";
    $sql .= "WHERE USER_PEER.UID = '$uid' AND USER_PEER.PEER_UID = '$peer_uid'";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows > 0) {

        list($peer_nickname) = $result->fetch_row();
        return $peer_nickname;
    }

    return user_get_nickname($peer_uid);
}

function user_search_relationships($user_search, $page = 1, $exclude_uid = 0)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($page) || ($page < 1)) $page = 1;

    if (!is_numeric($exclude_uid)) $exclude_uid = 0;

    $offset = calculate_page_offset($page, 10);

    if (!($table_prefix = get_table_prefix())) return false;

    $user_search_peers_array = array();

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    $user_search_array = preg_split('/,\s*/u', trim($user_search, ', '));
    $user_search_array = array_map('user_search_array_clean', $user_search_array);

    $user_search_logon = implode("%' OR LOGON LIKE '", $user_search_array);
    $user_search_nickname = implode("%' OR NICKNAME LIKE '", $user_search_array);

    $sql = "SELECT SQL_CALC_FOUND_ROWS USER.UID, USER.LOGON, USER.NICKNAME, ";
    $sql .= "USER_PEER.PEER_NICKNAME, USER_PEER.RELATIONSHIP ";
    $sql .= "FROM USER USER LEFT JOIN `{$table_prefix}USER_PEER` USER_PEER ";
    $sql .= "ON (USER_PEER.PEER_UID = USER.UID AND USER_PEER.UID = '{$_SESSION['UID']}') ";
    $sql .= "WHERE (LOGON LIKE '$user_search_logon%' ";
    $sql .= "OR NICKNAME LIKE '$user_search_nickname%') ";
    $sql .= "AND USER.UID <> $exclude_uid LIMIT $offset, 10";

    if (!($result = $db->query($sql))) return false;

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!($result_count = $db->query($sql))) return false;

    list($user_search_peers_count) = $result_count->fetch_row();

    if (($result->num_rows == 0) && ($user_search_peers_count > 0) && ($page > 1)) {
        return user_search_relationships($user_search, $page - 1, $exclude_uid);
    }

    while (($user_data = $result->fetch_assoc()) !== null) {

        if (isset($user_data['LOGON']) && isset($user_data['PEER_NICKNAME'])) {
            if (!is_null($user_data['PEER_NICKNAME']) && strlen($user_data['PEER_NICKNAME']) > 0) {
                $user_data['NICKNAME'] = $user_data['PEER_NICKNAME'];
            }
        }

        if (!isset($user_data['LOGON'])) $user_data['LOGON'] = gettext("Unknown user");
        if (!isset($user_data['NICKNAME'])) $user_data['NICKNAME'] = "";

        $user_search_peers_array[$user_data['UID']] = $user_data;
    }

    return array(
        'user_count' => $user_search_peers_count,
        'user_array' => $user_search_peers_array
    );
}

function user_get_word_filter_list($page)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($page)) $page = 1;

    $offset = calculate_page_offset($page, 10);

    $word_filter_array = array();

    if (!($table_prefix = get_table_prefix())) return false;

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    $sql = "SELECT SQL_CALC_FOUND_ROWS FID, FILTER_NAME, MATCH_TEXT, ";
    $sql .= "REPLACE_TEXT, FILTER_TYPE, FILTER_ENABLED ";
    $sql .= "FROM `{$table_prefix}WORD_FILTER` ";
    $sql .= "WHERE UID = '{$_SESSION['UID']}' ORDER BY FID ";
    $sql .= "LIMIT $offset, 10";

    if (!($result = $db->query($sql))) return false;

    $sql = "SELECT FOUND_ROWS() AS ROW_COUNT";

    if (!($result_count = $db->query($sql))) return false;

    list($word_filter_count) = $result_count->fetch_row();

    if (($result->num_rows == 0) && ($word_filter_count > 0) && ($page > 1)) {
        return user_get_word_filter_list($page - 1);
    }

    while (($word_filter_data = $result->fetch_assoc()) !== null) {
        $word_filter_array[$word_filter_data['FID']] = $word_filter_data;
    }

    return array(
        'word_filter_count' => $word_filter_count,
        'word_filter_array' => $word_filter_array
    );
}

function user_get_word_filter($filter_id)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($filter_id)) return false;

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT FID, FILTER_NAME, MATCH_TEXT, REPLACE_TEXT, FILTER_TYPE, ";
    $sql .= "FILTER_ENABLED FROM `{$table_prefix}WORD_FILTER` ";
    $sql .= "WHERE FID = '$filter_id' AND UID = '{$_SESSION['UID']}' ";
    $sql .= "ORDER BY FID";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows == 0) return false;

    $word_filter_array = $result->fetch_assoc();

    return $word_filter_array;
}

function user_get_word_filter_count()
{
    if (!$db = db::get()) return false;

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT COUNT(FID) AS FILTER_COUNT ";
    $sql .= "FROM `{$table_prefix}WORD_FILTER` ";
    $sql .= "WHERE UID = '{$_SESSION['UID']}'";

    if (!($result = $db->query($sql))) return false;

    list($word_filter_count) = $result->fetch_row();

    return $word_filter_count;
}

function user_clear_word_filter()
{
    if (!$db = db::get()) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    $sql = "DELETE QUICK FROM `{$table_prefix}WORD_FILTER` WHERE UID = '{$_SESSION['UID']}'";

    if (!$db->query($sql)) return false;

    return true;
}

function user_add_word_filter($filter_name, $match_text, $replace_text, $filter_option, $filter_enabled)
{
    if (!$db = db::get()) return false;

    $filter_name = $db->escape($filter_name);
    $match_text = $db->escape($match_text);
    $replace_text = $db->escape($replace_text);

    if (!is_numeric($filter_option)) return false;
    if (!is_numeric($filter_enabled)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    $sql = "INSERT INTO `{$table_prefix}WORD_FILTER` ";
    $sql .= "(UID, FILTER_NAME, MATCH_TEXT, REPLACE_TEXT, FILTER_TYPE, FILTER_ENABLED) ";
    $sql .= "VALUES ('{$_SESSION['UID']}', '$filter_name', '$match_text', '$replace_text', '$filter_option', '$filter_enabled')";

    if (!$db->query($sql)) return false;

    return true;
}

function user_update_word_filter($filter_id, $filter_name, $match_text, $replace_text, $filter_option, $filter_enabled)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($filter_id)) return false;

    if (!is_numeric($filter_option)) return false;
    if (!is_numeric($filter_enabled)) return false;

    $filter_name = $db->escape($filter_name);
    $match_text = $db->escape($match_text);
    $replace_text = $db->escape($replace_text);

    if (!($table_prefix = get_table_prefix())) return false;

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    $sql = "UPDATE LOW_PRIORITY `{$table_prefix}WORD_FILTER` SET FILTER_NAME = '$filter_name', ";
    $sql .= "MATCH_TEXT = '$match_text', REPLACE_TEXT = '$replace_text', ";
    $sql .= "FILTER_TYPE = '$filter_option', FILTER_ENABLED = '$filter_enabled' ";
    $sql .= "WHERE UID = '{$_SESSION['UID']}' AND FID = '$filter_id'";

    if (!$db->query($sql)) return false;

    return true;
}

function user_delete_word_filter($filter_id)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($filter_id)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!isset($_SESSION['UID']) || !is_numeric($_SESSION['UID'])) return false;

    $sql = "DELETE QUICK FROM `{$table_prefix}WORD_FILTER` ";
    $sql .= "WHERE UID = '{$_SESSION['UID']}' AND FID = '$filter_id'";

    if (!$db->query($sql)) return false;

    return true;
}

function user_is_active($uid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    if (!($forum_fid = get_forum_fid())) return false;

    $sql = "SELECT COUNT(*) FROM SESSIONS WHERE UID = '$uid' ";
    $sql .= "AND FID = '$forum_fid'";

    if (!($result = $db->query($sql))) return false;

    list($user_active_count) = $result->fetch_row();

    return ($user_active_count > 0);
}

function user_allow_pm($uid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    $sql = "SELECT COUNT(UID) FROM USER_PREFS ";
    $sql .= "WHERE UID = '$uid' AND ALLOW_PM = 'Y'";

    if (!($result = $db->query($sql))) return false;

    list($allow_pm_count) = $result->fetch_row();

    return ($allow_pm_count > 0);
}

function user_allow_email($uid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    $sql = "SELECT COUNT(UID) FROM USER_PREFS ";
    $sql .= "WHERE UID = '$uid' AND ALLOW_EMAIL = 'Y'";

    if (!($result = $db->query($sql))) return false;

    list($allow_email_count) = $result->fetch_row();

    return ($allow_email_count > 0);
}

function user_prefs_filter_attachments($image_attachments_array, $max_width, $max_height)
{
    $attachments_array_filtered = array('' => '&nbsp;');

    if (!($attachment_dir = attachments_check_dir())) return array();

    if (!is_array($image_attachments_array) || sizeof($image_attachments_array) == 0) {
        return $attachments_array_filtered;
    }

    foreach ($image_attachments_array as $hash => $attachment_details) {

        if (!($image_info = @getimagesize("$attachment_dir/$hash"))) {
            continue;
        }

        if (($image_info[0] > $max_width) || ($image_info[1] > $max_height)) {
            continue;
        }

        $attachments_array_filtered[$attachment_details['aid']] = $attachment_details['filename'];
    }

    return $attachments_array_filtered;
}

function user_get_local_time()
{
    if (isset($_SESSION['TIMEZONE']) && is_numeric($_SESSION['TIMEZONE'])) {
        $timezone_id = $_SESSION['TIMEZONE'];
    } else {
        $timezone_id = forum_get_setting('forum_timezone', 'is_numeric', 27);
    }

    if (isset($_SESSION['GMT_OFFSET']) && is_numeric($_SESSION['GMT_OFFSET'])) {
        $gmt_offset = $_SESSION['GMT_OFFSET'];
    } else {
        $gmt_offset = forum_get_setting('forum_gmt_offset', 'is_numeric', 0);
    }

    if (isset($_SESSION['DST_OFFSET']) && is_numeric($_SESSION['DST_OFFSET'])) {
        $dst_offset = $_SESSION['DST_OFFSET'];
    } else {
        $dst_offset = forum_get_setting('forum_dst_offset', 'is_numeric', 0);
    }

    if (isset($_SESSION['DL_SAVING']) && in_array($_SESSION['DL_SAVING'], array('Y', 'N'))) {
        $dl_saving = $_SESSION['DL_SAVING'];
    } else {
        $dl_saving = forum_get_setting('forum_dl_saving', 'strlen', 'N');
    }

    if ($dl_saving == "Y" && timestamp_is_dst($timezone_id, $gmt_offset)) {
        $local_time = time() + ($gmt_offset * HOUR_IN_SECONDS) + ($dst_offset * HOUR_IN_SECONDS);
    } else {
        $local_time = time() + ($gmt_offset * HOUR_IN_SECONDS);
    }

    return $local_time;
}

function user_get_posts($uid)
{
    if (!$db = db::get()) return false;

    if (!is_numeric($uid)) return false;

    if (!($table_prefix = get_table_prefix())) return false;

    $sql = "SELECT TID, PID FROM `{$table_prefix}POST` WHERE FROM_UID = '$uid'";

    if (!($result = $db->query($sql))) return false;

    if ($result->num_rows) {

        $user_post_array = array();

        while (($post_data = $result->fetch_assoc()) !== null) {

            $user_post_array[] = $post_data;
        }

        return $user_post_array;

    }

    return false;
}