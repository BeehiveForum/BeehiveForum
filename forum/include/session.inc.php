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
require_once BH_INCLUDE_PATH . 'format.inc.php';
require_once BH_INCLUDE_PATH . 'forum.inc.php';
require_once BH_INCLUDE_PATH . 'html.inc.php';
require_once BH_INCLUDE_PATH . 'ip.inc.php';
require_once BH_INCLUDE_PATH . 'perm.inc.php';
require_once BH_INCLUDE_PATH . 'server.inc.php';
require_once BH_INCLUDE_PATH . 'user.inc.php';

// End Required includes

abstract class session
{
    /** @var db */
    protected static $db;

    public static function init()
    {
        session::$db = db::get(true);

        if (!ini_get('session.gc_probability')) {
            @ini_set('session.gc_probability', 1);
        }

        if (!ini_get('session.gc_divisor')) {
            @ini_set('session.gc_divisor', 100);
        }

        session_set_save_handler(
            array('session', 'open'),
            array('session', 'close'),
            array('session', 'read'),
            array('session', 'write'),
            array('session', 'destroy'),
            array('session', 'gc')
        );

        session_name('sess_hash');

        if (!html_get_cookie('sess_hash')) {

            if (($hash = session::restore())) {

                session_id($hash);

            } else {

                html_set_cookie('user_logon', '', time() - YEAR_IN_SECONDS);
                html_set_cookie('user_token', '', time() - YEAR_IN_SECONDS);
            }
        }

        session_start();

        if (!isset($_SESSION['UID'])) {
            $_SESSION['UID'] = 0;
        }
    }

    public static function restore()
    {
        if (!($user_logon = html_get_cookie('user_logon'))) return false;

        if (!($user_token = html_get_cookie('user_token'))) return false;

        if (!($uid = user_logon_token($user_logon, $user_token))) return false;

        $user_logon = session::$db->escape($user_logon);

        $user_token = session::$db->escape($user_token);

        $current_datetime = date(MYSQL_DATETIME, time());

        $sql = "SELECT SESSIONS.ID FROM USER_TOKEN INNER JOIN USER ON (USER.UID = USER_TOKEN.UID) ";
        $sql .= "LEFT JOIN SESSIONS ON (SESSIONS.UID = USER_TOKEN.UID) WHERE USER.LOGON = '$user_logon'";
        $sql .= "AND USER_TOKEN.TOKEN = '$user_token' AND USER_TOKEN.EXPIRES > '$current_datetime' ";
        $sql .= "AND USER.UID = '$uid' GROUP BY USER.UID";

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

        $sql = "SELECT DATA, MD5 FROM SESSIONS WHERE ID = '$id' ";

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

        if (!($search_id = session::is_search_engine())) $search_id = 'NULL';

        $sql = "REPLACE INTO SESSIONS (ID, UID, FID, DATA, MD5, TIME, IPADDRESS, REFERER, SID) ";
        $sql .= "VALUES ('$id', '$uid', '$forum_fid', '$data', '$md5', CAST('$time' AS DATETIME), ";
        $sql .= "'$ip_address', '$http_referer', $search_id)";

        if (!(session::$db->query($sql))) return false;

        return true;
    }

    public static function get_http_referer()
    {
        if (!isset($_SERVER['HTTP_REFERER']) || strlen(trim($_SERVER['HTTP_REFERER'])) == 0) return '';
        return $_SERVER['HTTP_REFERER'];
    }

    public static function is_search_engine()
    {
        if (!array_key_exists('SID', $_SESSION)) {

            $http_user_agent = session::$db->escape(session::get_user_agent());

            $sql = "SELECT SID FROM SEARCH_ENGINE_BOTS ";
            $sql .= "WHERE '$http_user_agent' LIKE AGENT_MATCH ";

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

    public static function get_user_agent()
    {
        if (!isset($_SERVER['HTTP_USER_AGENT']) || strlen(trim($_SERVER['HTTP_USER_AGENT'])) == 0) return '';
        return $_SERVER['HTTP_USER_AGENT'];
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
        $current_datetime = date(MYSQL_DATETIME, time());

        $expires_datetime = date(MYSQL_DATETIME, time() - ($lifetime + DAY_IN_SECONDS));

        $sql = "DELETE FROM SESSIONS USING SESSIONS LEFT JOIN (SELECT UID, ";
        $sql .= "MAX(EXPIRES) AS EXPIRES FROM USER_TOKEN GROUP BY UID) AS TOKENS ";
        $sql .= "ON (TOKENS.UID = SESSIONS.UID) WHERE TIME < CAST('$expires_datetime' AS DATETIME) ";
        $sql .= "AND (TOKENS.UID IS NULL OR TOKENS.EXPIRES < CAST('$current_datetime' AS DATETIME))";

        if (!(session::$db->query($sql))) return false;

        return true;
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

    public static function show_sigs()
    {
        if (!session::logged_in()) {
            return true;
        }

        return isset($_SESSION['VIEW_SIGS']) && ($_SESSION['VIEW_SIGS'] == 'Y');
    }

    public static function logged_in()
    {
        return isset($_SESSION['UID']) && is_numeric($_SESSION['UID']) && ($_SESSION['UID'] > 0);
    }

    public static function get_folders_by_perm($perm, $forum_fid = null)
    {
        if (!is_numeric($perm)) return false;

        if (!is_numeric($forum_fid) && !($forum_fid = get_forum_fid())) $forum_fid = 0;

        if (!isset($_SESSION['PERMS'][$forum_fid])) {

            $_SESSION['PERMS'][$forum_fid] = array();

            if (($user_perms = session::get_perm_array($_SESSION['UID'], $forum_fid))) {
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

    public static function get_perm_array($uid, $forum_fid)
    {
        $user_perm_array = array();

        if (!is_numeric($uid)) return $user_perm_array;

        if (!is_numeric($forum_fid)) return $user_perm_array;

        if (($table_prefix = forum_get_table_prefix($forum_fid))) {

            $sql = "SELECT FID, PERM, IF (PERM IS NULL, 0, 1) AS FOLDER_PERM_COUNT ";
            $sql .= "FROM `{$table_prefix}FOLDER`";

            if (!($result = session::$db->query($sql))) return $user_perm_array;

            if ($result->num_rows == 0) return $user_perm_array;

            while (($permission_data = $result->fetch_assoc()) !== null) {

                if ($permission_data['FOLDER_PERM_COUNT'] > 0) {

                    $user_perm_array[$forum_fid][$permission_data['FID']] = (double)$permission_data['PERM'];
                }
            }
        }

        $sql = "SELECT FORUM, FID, BIT_OR(PERM) AS PERM FROM ((SELECT GROUPS.FORUM, ";
        $sql .= "GROUP_PERMS.FID, BIT_OR(GROUP_PERMS.PERM) AS PERM, COUNT(GROUP_PERMS.GID) AS PERM_COUNT ";
        $sql .= "FROM GROUPS INNER JOIN GROUP_PERMS ON (GROUP_PERMS.GID = GROUPS.GID) ";
        $sql .= "INNER JOIN GROUP_USERS ON (GROUP_USERS.GID = GROUPS.GID) WHERE GROUP_USERS.UID = '$uid' ";
        $sql .= "AND GROUPS.FORUM = $forum_fid GROUP BY GROUPS.FORUM, GROUP_PERMS.FID HAVING PERM_COUNT > 0) ";
        $sql .= "UNION ALL (SELECT USER_PERM.FORUM, USER_PERM.FID, BIT_OR(USER_PERM.PERM) AS PERM, ";
        $sql .= "COUNT(USER_PERM.UID) AS PERM_COUNT FROM USER_PERM WHERE USER_PERM.UID = '$uid' ";
        $sql .= "AND USER_PERM.FORUM IN (0, $forum_fid) GROUP BY USER_PERM.FORUM, USER_PERM.FID ";
        $sql .= "HAVING PERM_COUNT > 0)) AS USER_GROUP_PERMS GROUP BY FORUM, FID";

        if (!($result = session::$db->query($sql))) return $user_perm_array;

        if ($result->num_rows == 0) return $user_perm_array;

        while (($permission_data = $result->fetch_assoc()) !== null) {

            if (isset($user_perm_array[$permission_data['FORUM']][$permission_data['FID']])) {

                if (($user_perm_array[$permission_data['FORUM']][$permission_data['FID']] & USER_PERM_THREAD_MOVE) > 0) {
                    $permission_data['PERM'] = (double)$permission_data['PERM'] | USER_PERM_THREAD_MOVE;
                }
            }

            $user_perm_array[$permission_data['FORUM']][$permission_data['FID']] = (double)$permission_data['PERM'];
        }

        return $user_perm_array;
    }

    public static function user_approved()
    {
        $forum_access_ignore_files_preg = implode("|^", array_map('preg_quote_callback', get_forum_access_ignore_files()));

        if (preg_match("/^$forum_access_ignore_files_preg/u", basename($_SERVER['PHP_SELF'])) > 0) {
            return true;
        }

        if (!session::logged_in()) return true;

        if (session::check_perm(USER_PERM_ADMIN_TOOLS, 0)) return true;

        if (forum_get_setting('require_user_approval', 'Y')) {
            return (isset($_SESSION['APPROVED']) && $_SESSION['APPROVED'] > 0);
        }

        return true;
    }

    public static function check_perm($perm, $folder_fid, $forum_fid = null)
    {
        if (!is_numeric($folder_fid)) return false;

        if (!is_numeric($forum_fid) && !($forum_fid = get_forum_fid())) $forum_fid = 0;

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

    public static function end()
    {
        session::start(0);
    }

    public static function start($uid)
    {
        if (!($forum_fid = get_forum_fid())) $forum_fid = 0;

        if (!($user = user_get($uid))) {

            $user = array(
                'UID' => 0,
                'LOGON' => 'GUEST',
                'NICKNAME' => 'Guest',
                'EMAIL' => '',
            );
        }

        unset($user['IPADDRESS'], $user['PASSWD'], $user['REFERER'], $user['PEER_NICKNAME']);

        $_SESSION = array_merge($_SESSION, $user);

        $_SESSION['FID'] = $forum_fid;

        $_SESSION['IPADDRESS'] = get_ip_address();

        if (session::logged_in() && ($user_prefs = user_get_prefs($uid))) {
            $_SESSION = array_merge($_SESSION, $user_prefs);
        } else {
            $_SESSION = array_merge($_SESSION, user_get_pref_names(array('STYLE')));
        }

        if (($user_perms = session::get_perm_array($uid, $forum_fid))) {
            $_SESSION['PERMS'] = $user_perms;
        }

        if (!isset($_SESSION['RAND_HASH'])) {
            $_SESSION['RAND_HASH'] = md5(uniqid(mt_rand()));
        }

        if ($uid > 0 && !forum_get_last_visit($uid) && ($gid = perm_get_default_group())) {
            perm_add_user_to_group($uid, $gid);
        }
    }

    public static function update_visitor_log($uid, $force_update = false)
    {
        $http_referer = session::$db->escape(session::get_http_referer());

        $user_agent = session::$db->escape(session::get_user_agent());

        $ip_address = session::$db->escape(get_ip_address());

        if (!($forum_fid = get_forum_fid())) $forum_fid = 0;

        $current_datetime = date(MYSQL_DATETIME, time());

        $uid = (is_numeric($uid) && ($uid > 0)) ? session::$db->escape($uid) : 'NULL';

        if (!($search_id = session::is_search_engine())) $search_id = 'NULL';

        if (!$force_update) {

            $sql = "SELECT UNIX_TIMESTAMP(MAX(LAST_LOGON)) FROM VISITOR_LOG WHERE FORUM = $forum_fid ";
            $sql .= "AND ((UID = $uid AND $uid IS NOT NULL) OR (SID = $search_id AND $search_id IS NOT NULL) ";
            $sql .= "OR (IPADDRESS = '$ip_address' AND $uid IS NULL AND $search_id IS NULL))";

            if (!($result = session::$db->query($sql))) return false;

            list($last_logon) = $result->fetch_row();
        }

        if (!isset($last_logon) || ($last_logon < (time() - HOUR_IN_SECONDS))) {

            $sql = "REPLACE INTO VISITOR_LOG (FORUM, UID, LAST_LOGON, IPADDRESS, REFERER, USER_AGENT, SID) ";
            $sql .= "VALUES ('$forum_fid', $uid, CAST('$current_datetime' AS DATETIME), '$ip_address', ";
            $sql .= "'$http_referer', '$user_agent', $search_id)";

            if (!session::$db->query($sql)) return false;
        }

        return true;
    }
}