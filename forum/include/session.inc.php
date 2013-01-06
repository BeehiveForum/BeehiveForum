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
require_once BH_INCLUDE_PATH. 'constants.inc.php';
require_once BH_INCLUDE_PATH. 'db.inc.php';
require_once BH_INCLUDE_PATH. 'forum.inc.php';
require_once BH_INCLUDE_PATH. 'html.inc.php';
require_once BH_INCLUDE_PATH. 'ip.inc.php';
require_once BH_INCLUDE_PATH. 'user.inc.php';
// End Required includes

abstract class session
{
    protected static $db;

    public static function init()
    {
        session::$db = db::get(true);

        session_set_save_handler(
            array('session', 'open'),
            array('session', 'close'),
            array('session', 'read'),
            array('session', 'write'),
            array('session', 'destroy'),
            array('session', 'gc')
        );

        session_name('sess_hash');

        if (!html_get_cookie('sess_hash') && ($hash = session::restore())) {
            session_id($hash);
        }

        session_start();

        if (!isset($_SESSION['UID'])) $_SESSION['UID'] = 0;

        session::refresh($_SESSION['UID']);
    }

    public static function open()
    {
        return true;
    }

    public static function close()
    {
        return true;
    }

    public static function read($id)
    {
        $id = session::$db->escape($id);

        $user_agent = session::$db->escape(session::get_user_agent());

        $sql = "SELECT DATA, MD5 FROM SESSIONS WHERE ID = '$id' ";
        $sql.= "AND USER_AGENT = '$user_agent'";

        if (!($result = session::$db->query($sql))) return '';

        if ($result->num_rows == 0) return '';

        list($data, $md5) = $result->fetch_row();

        if (md5($data) != $md5) return '';

        return $data;
    }

    public static function write($id, $data)
    {
        $id = session::$db->escape($id);

        if (!($forum_fid = get_forum_fid())) $forum_fid = 0;

        $md5 = session::$db->escape(md5($data));

        $data = session::$db->escape($data);

        $time = date(MYSQL_DATETIME, time());

        $uid = session::$db->escape($_SESSION['UID']);

        $ip_address = session::$db->escape(get_ip_address());

        $http_referer = session::$db->escape(session::get_http_referer());

        $user_agent = session::$db->escape(session::get_user_agent());

        if (!($search_id = session::is_search_engine())) $search_id = 'NULL';

        $sql = "REPLACE INTO SESSIONS (ID, UID, FID, DATA, MD5, TIME, IPADDRESS, REFERER, USER_AGENT, SID) ";
        $sql.= "VALUES ('$id', '$uid', '$forum_fid', '$data', '$md5', CAST('$time' AS DATETIME), ";
        $sql.= "'$ip_address', '$http_referer', '$user_agent', $search_id)";

        if (!(session::$db->query($sql))) return false;

        return true;
    }

    public static function destroy($id)
    {
        $id = session::$db->escape($id);

        $sql = "DELETE FROM SESSIONS WHERE ID = '$id'";

        if (!(session::$db->query($sql))) return false;

        return true;
    }

    public static function gc($lifetime)
    {
        $expires_datetime = date(MYSQL_DATETIME, time() - ($lifetime + DAY_IN_SECONDS));

        $sql = "DELETE FROM SESSIONS WHERE TIME < CAST('$expires_datetime' AS DATETIME)";

        if (!(session::$db->query($sql))) return false;

        return true;
    }

    public static function get_http_referer()
    {
        if (!isset($_SERVER['HTTP_REFERER']) || strlen(trim($_SERVER['HTTP_REFERER'])) == 0) return '';

        $http_referer = trim($_SERVER['HTTP_REFERER']);

        $forum_uri_preg = preg_quote(html_get_forum_uri(), '/');

        if (preg_match("/^$forum_uri_preg/iu", $http_referer) > 0) $http_referer = '';

        return $http_referer;
    }

    public static function get_user_agent()
    {
        if (!isset($_SERVER['HTTP_USER_AGENT']) || strlen(trim($_SERVER['HTTP_USER_AGENT'])) == 0) return '';

        return $_SERVER['HTTP_USER_AGENT'];
    }

    public static function is_search_engine()
    {
        if (!array_key_exists('SID', $_SESSION)) {

            $http_user_agent = session::$db->escape(session::get_user_agent());

            $sql = "SELECT SID FROM SEARCH_ENGINE_BOTS ";
            $sql.= "WHERE '$http_user_agent' LIKE AGENT_MATCH ";

            if (!($result = session::$db->query($sql))) {

                $_SESSION['SID'] = false;
                return $_SESSION['SID'];
            }

            if ($result->num_rows == 0) {

                $_SESSION['SID'] = false;
                return $_SESSION['SID'];
            }

            list($sid) = $result->fetch_row();

            $_SESSION['SID'] = $sid;
        }

        return $_SESSION['SID'];
    }

    public static function get_post_page_prefs()
    {
        if (!array_key_exists('POST_PAGE', $_SESSION)) {

            $_SESSION['POST_PAGE'] = (double)POST_EMOTICONS_DISPLAY
                | POST_SIGNATURE_DISPLAY
                | POLL_ADVANCED_DISPLAY
                | POLL_ADDITIONAL_MESSAGE_DISPLAY
                | POLL_EDIT_SOFT_DISPLAY
                | POST_ATTACHMENT_DISPLAY;
        }

        return $_SESSION['POST_PAGE'];
    }

    public static function get_folders_by_perm($perm, $forum_fid = false)
    {
        if (!is_numeric($perm)) return false;

        if (!isset($_SESSION['PERMS'])) return false;

        if (!(is_numeric($forum_fid) || ($forum_fid = get_forum_fid()))) return false;

        if (!isset($_SESSION['PERMS'][$forum_fid])) {

            $_SESSION['PERMS'][$forum_fid] = array();

            if (($user_perms = session::get_perm_array($_SESSION['UID'], $forum_fid)) !== false) {
                $_SESSION['PERMS'][$forum_fid] = $user_perms[$forum_fid];
            }
        }

        $folder_fids = array();

        if (isset($_SESSION['PERMS'][$forum_fid][0])) {
            $global_perm = $_SESSION['PERMS'][$forum_fid][0];
        } else {
            $global_perm = 0;
        }

        if (isset($_SESSION['PERMS'][$forum_fid]) && is_array($_SESSION['PERMS'][$forum_fid])) {

            foreach ($_SESSION['PERMS'][$forum_fid] as $folder_fid => $folder_perm) {

                if ((($folder_perm & $perm) == $perm) || (($global_perm & $perm) == $perm)) {

                    $folder_fids[$folder_fid] = $folder_fid;
                }
            }
        }

        if (count($folder_fids) == 0) return false;

        return $folder_fids;
    }

    public static function user_approved()
    {
        if (!session::logged_in()) return true;

        if (session::check_perm(USER_PERM_ADMIN_TOOLS, 0)) return true;

        if (forum_get_setting('require_user_approval', 'Y')) {
            return (isset($_SESSION['APPROVED']) && $_SESSION['APPROVED'] > 0);
        }

        return true;
    }

    public static function user_banned()
    {
        if (session::check_perm(USER_PERM_BANNED, 0)) return true;

        if (session::check_perm(USER_PERM_BANNED, 0, 0)) return true;

        return false;
    }

    public static function get_perm($folder_fid)
    {
        if (!is_numeric($folder_fid)) return false;

        if (!($forum_fid = get_forum_fid())) return false;

        $user_perm = false;

        if (!session::logged_in()) {

            if (isset($_SESSION['PERMS'][$forum_fid][$folder_fid])) {
                $user_perm = $user_perm | $_SESSION['PERMS'][$forum_fid][$folder_fid];
            }

        } else {

            if (isset($_SESSION['PERMS'][$forum_fid][$folder_fid])) {
                $user_perm = $user_perm | $_SESSION['PERMS'][$forum_fid][$folder_fid];
            }

            if (isset($_SESSION['PERMS'][0][$folder_fid])) {
                $user_perm = $user_perm | $_SESSION['PERMS'][0][$folder_fid];
            }
        }

        return $user_perm;
    }

    public static function check_perm($perm, $folder_fid, $forum_fid = false)
    {
        if (!is_numeric($folder_fid)) return false;

        if (!(is_numeric($forum_fid) || ($forum_fid = get_forum_fid()))) $forum_fid = 0;

        $user_perm_test = 0;

        if (!session::logged_in()) {

            if (isset($_SESSION['PERMS'][$forum_fid][$folder_fid])) {
                $user_perm_test = $user_perm_test | $_SESSION['PERMS'][$forum_fid][$folder_fid];
            }

        } else {

            if (isset($_SESSION['PERMS'][$forum_fid][0])) {
                $user_perm_test = $user_perm_test | $_SESSION['PERMS'][$forum_fid][0];
            }

            if (isset($_SESSION['PERMS'][$forum_fid][$folder_fid])) {
                $user_perm_test = $user_perm_test | $_SESSION['PERMS'][$forum_fid][$folder_fid];
            }

            if (isset($_SESSION['PERMS'][0][0])) {
                $user_perm_test = $user_perm_test | $_SESSION['PERMS'][0][0];
            }
        }

        return (($user_perm_test & $perm) == $perm);
    }

    public static function update_user_time($uid)
    {
        if (!($table_prefix = get_table_prefix())) return false;

        if (!($forum_fid = get_forum_fid())) return false;

        $uid = session::$db->escape($uid);

        $sql = "INSERT INTO `{$table_prefix}USER_TRACK` (UID, USER_TIME_BEST) ";
        $sql.= "SELECT USER_FORUM.UID, FROM_UNIXTIME(UNIX_TIMESTAMP(SESSIONS.TIME) - UNIX_TIMESTAMP(USER_FORUM.LAST_VISIT)) ";
        $sql.= "FROM SESSIONS LEFT JOIN USER_FORUM ON (USER_FORUM.UID = SESSIONS.UID AND USER_FORUM.FID = SESSIONS.FID) ";
        $sql.= "LEFT JOIN `{$table_prefix}USER_TRACK` USER_TRACK ON (USER_TRACK.UID = USER_FORUM.UID) ";
        $sql.= "WHERE SESSIONS.UID = '$uid' AND SESSIONS.FID = '$forum_fid' AND ((SESSIONS.TIME > USER_FORUM.LAST_VISIT ";
        $sql.= "AND (UNIX_TIMESTAMP(SESSIONS.TIME) - UNIX_TIMESTAMP(USER_FORUM.LAST_VISIT)) > UNIX_TIMESTAMP(USER_TRACK.USER_TIME_BEST)) ";
        $sql.= "OR USER_TRACK.USER_TIME_BEST IS NULL) ON DUPLICATE KEY UPDATE USER_TIME_BEST = VALUES(USER_TIME_BEST)";

        if (!session::$db->query($sql)) return false;

        $sql = "INSERT INTO `{$table_prefix}USER_TRACK` (UID, USER_TIME_TOTAL, USER_TIME_UPDATED) ";
        $sql.= "SELECT UID, FROM_UNIXTIME(USER_TIME_TOTAL + (TIME_END - TIME_START)) AS USER_TIME_TOTAL, ";
        $sql.= "FROM_UNIXTIME(TIME_END) AS USER_TIME_UPDATED FROM (SELECT UID, USER_TIME_TOTAL, ";
        $sql.= "IF (USER_TIME_UPDATED >= LAST_VISIT, USER_TIME_UPDATED, LAST_VISIT) AS TIME_START, ";
        $sql.= "IF (session::TIME >= USER_TIME_UPDATED, SESSION_TIME, USER_TIME_UPDATED) AS TIME_END ";
        $sql.= "FROM (SELECT USER_FORUM.UID, COALESCE(UNIX_TIMESTAMP(USER_TRACK.USER_TIME_UPDATED), 0) AS USER_TIME_UPDATED, ";
        $sql.= "COALESCE(UNIX_TIMESTAMP(USER_FORUM.LAST_VISIT), 0) AS LAST_VISIT, COALESCE(UNIX_TIMESTAMP(SESSIONS.TIME), 0) AS session::TIME, ";
        $sql.= "COALESCE(UNIX_TIMESTAMP(USER_TRACK.USER_TIME_TOTAL), 0) AS USER_TIME_TOTAL FROM SESSIONS ";
        $sql.= "INNER JOIN USER_FORUM ON (USER_FORUM.UID = SESSIONS.UID AND USER_FORUM.FID = SESSIONS.FID) ";
        $sql.= "LEFT JOIN `{$table_prefix}USER_TRACK` USER_TRACK ON (USER_TRACK.UID = USER_FORUM.UID) ";
        $sql.= "WHERE SESSIONS.UID = '$uid' AND SESSIONS.FID = '$forum_fid') AS USER_TIMES) AS TIME_COMPARE ";
        $sql.= "ON DUPLICATE KEY UPDATE USER_TIME_TOTAL = VALUES(USER_TIME_TOTAL), ";
        $sql.= "USER_TIME_UPDATED = VALUES(USER_TIME_UPDATED)";

        if (!session::$db->query($sql)) return false;

        return true;
    }

    public static function update_visitor_log($uid, $forum_fid)
    {
        $ip_address = get_ip_address();

        $http_referer = session::$db->escape(session::get_http_referer());

        $user_agent = session::$db->escape(session::get_user_agent());

        $ip_address = session::$db->escape($ip_address);

        $current_datetime = date(MYSQL_DATETIME, time());

        $uid = (is_numeric($uid) && ($uid > 0)) ? $uid : 'NULL';

        if (!($search_id = session::is_search_engine())) $search_id = 'NULL';

        $sql = "REPLACE INTO VISITOR_LOG (FORUM, UID, LAST_LOGON, IPADDRESS, REFERER, USER_AGENT, SID) ";
        $sql.= "VALUES ('$forum_fid', $uid, CAST('$current_datetime' AS DATETIME), '$ip_address', ";
        $sql.= "'$http_referer', '$user_agent', $search_id)";

        if (!session::$db->query($sql)) return false;

        return true;
    }

    public static function get_value($key)
    {
        if (isset($_SESSION[$key])) return $_SESSION[$key];

        if (mb_strtoupper($key) == 'UID') return 0;

        return false;
    }

    public static function set_value($key, $value)
    {
        $_SESSION[$key] = $value;
        return true;
    }

    public static function unset_value($key)
    {
        unset($_SESSION[$key]);
    }

    public static function get_perm_array($uid, $forum_fid)
    {
        $user_perm_array = array();

        if (!is_numeric($uid)) return $user_perm_array;

        if (!is_numeric($forum_fid)) return $user_perm_array;

        if (!($table_prefix = forum_get_table_prefix($forum_fid))) return $user_perm_array;

        $sql = "SELECT FID, PERM, IF (PERM IS NULL, 0, 1) AS FOLDER_PERM_COUNT ";
        $sql.= "FROM `{$table_prefix}FOLDER`";

        if (!($result = session::$db->query($sql))) return $user_perm_array;

        if ($result->num_rows == 0) return $user_perm_array;

        while (($permission_data = $result->fetch_assoc()) !== null) {

            if ($permission_data['FOLDER_PERM_COUNT'] > 0) {

                $user_perm_array[$forum_fid][$permission_data['FID']] = (double)$permission_data['PERM'];
            }
        }

        $sql = "SELECT GROUP_PERMS.GID, GROUP_PERMS.FORUM, GROUP_PERMS.FID, ";
        $sql.= "BIT_OR(GROUP_PERMS.PERM) AS PERM, COUNT(GROUP_PERMS.GID) AS USER_PERM_COUNT ";
        $sql.= "FROM GROUP_USERS INNER JOIN GROUP_PERMS USING (GID) ";
        $sql.= "WHERE GROUP_USERS.UID = '$uid' AND GROUP_PERMS.FORUM IN (0, $forum_fid) ";
        $sql.= "GROUP BY GROUP_PERMS.FORUM, GROUP_PERMS.FID";

        if (!($result = session::$db->query($sql))) return $user_perm_array;

        if ($result->num_rows == 0) return $user_perm_array;

        while (($permission_data = $result->fetch_assoc()) !== null) {

            if ($permission_data['USER_PERM_COUNT'] > 0) {

                if (isset($user_perm_array[$permission_data['FORUM']][$permission_data['FID']])) {

                    if (($user_perm_array[$permission_data['FORUM']][$permission_data['FID']] & USER_PERM_THREAD_MOVE) > 0) {
                        $permission_data['PERM'] = (double)$permission_data['PERM'] | USER_PERM_THREAD_MOVE;
                    }
                }

                $user_perm_array[$permission_data['FORUM']][$permission_data['FID']] = (double)$permission_data['PERM'];
            }
        }

        return $user_perm_array;
    }

    public static function restore()
    {
        if (!($user_logon = html_get_cookie('user_logon'))) return false;

        if (!($user_token = html_get_cookie('user_token'))) return false;

        if (!($uid = user_logon_token($user_logon, $user_token))) return false;

        $user_logon = session::$db->escape($user_logon);

        $user_token = session::$db->escape($user_token);

        $user_agent = session::$db->escape(session::get_user_agent());

        $current_datetime = date(MYSQL_DATETIME, time());

        $sql = "SELECT SESSIONS.ID FROM USER_TOKEN INNER JOIN USER ON (USER.UID = USER_TOKEN.UID) ";
        $sql.= "LEFT JOIN SESSIONS ON (SESSIONS.UID = USER_TOKEN.UID AND SESSIONS.USER_AGENT = '$user_agent') ";
        $sql.= "WHERE USER.LOGON = '$user_logon' AND USER_TOKEN.TOKEN = '$user_token' ";
        $sql.= "AND USER_TOKEN.EXPIRES > '$current_datetime' AND USER.UID = '$uid' ";
        $sql.= "GROUP BY USER.UID";

        if (!($result = session::$db->query($sql))) return false;

        if ($result->num_rows == 0) return false;

        list($id) = $result->fetch_row();

        if (isset($id) && !is_null($id)) {

            html_set_cookie('user_logon', $user_logon, time() + YEAR_IN_SECONDS);
            html_set_cookie('user_token', $user_token, time() + YEAR_IN_SECONDS);

            return $id;
        }

        return false;
    }

    public static function create($uid)
    {
        if (!($forum_fid = get_forum_fid())) $forum_fid = 0;

        session::refresh($uid);

        session::update_visitor_log($uid, $forum_fid);

        forum_update_last_visit($uid);
    }

    public static function refresh($uid)
    {
        $ip_address = get_ip_address();

        $http_referer = session::get_http_referer();

        if (!($forum_fid = get_forum_fid())) $forum_fid = 0;

        if (!($user = user_get($uid))) {

            $user = array(
                'UID' => 0,
                'LOGON' => 'GUEST',
                'NICKNAME' => 'Guest',
                'EMAIL' => '',
            );
        }

        unset($user['IPADDRESS'], $user['PASSWD'], $user['REFERER']);

        $_SESSION = array_merge($_SESSION, $user);

        $_SESSION['FID'] = $forum_fid;

        $_SESSION['IPADDRESS'] = get_ip_address();

        if (session::logged_in() && ($user_prefs = user_get_prefs($uid))) {
            $_SESSION = array_merge($_SESSION, $user_prefs);
        } else {
            $_SESSION = array_merge($_SESSION, user_get_pref_names(array('STYLE')));
        }

        if (($user_perms = session::get_perm_array($uid, $forum_fid)) !== false) {
            $_SESSION['PERMS'] = $user_perms;
        }

        if (!isset($_SESSION['REFERER'])) {
            $_SESSION['REFERER'] = session::get_http_referer();
        }

        if (!isset($_SESSION['RAND_HASH'])) {
            $_SESSION['RAND_HASH'] = md5(uniqid(mt_rand()));
        }
    }

    public static function end()
    {
        session::refresh(0);
    }

    public static function logged_in()
    {
        return isset($_SESSION['UID']) && is_numeric($_SESSION['UID']) && ($_SESSION['UID'] > 0);
    }
}

?>