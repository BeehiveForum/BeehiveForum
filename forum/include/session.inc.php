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

/**
 * session.inc.php - session functions
 *
 * Contains session related functions.
 */

/**
 *
 */

// We shouldn't be accessing this file directly.
if (basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "admin.inc.php");
include_once(BH_INCLUDE_PATH. "cache.inc.php");
include_once(BH_INCLUDE_PATH. "banned.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "ip.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "pm.inc.php");
include_once(BH_INCLUDE_PATH. "stats.inc.php");
include_once(BH_INCLUDE_PATH. "search.inc.php");
include_once(BH_INCLUDE_PATH. "threads.inc.php");
include_once(BH_INCLUDE_PATH. "text_captcha.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");
include_once(BH_INCLUDE_PATH. "visitor_log.inc.php");

/**
 * Get session data
 * 
 * Get data from the SESSIONS table for the specified
 * hash. If no match is found, returns false.
 * 
 * @param mixed $sess_hash
 * @return mixed
 */
function session_get($sess_hash)
{
    if (!($db_session_get = db_connect())) return false;
    
    if (!is_md5($sess_hash)) return false;
    
    if (($table_data = get_table_prefix())) {
        $forum_fid = $table_data['FID'];
    }else {
        $forum_fid = 0;
    }      
    
    $sess_hash = db_escape_string($sess_hash);
    
    $sql = "SELECT SESSIONS.HASH, SESSIONS.UID, SESSIONS.IPADDRESS, SESSIONS.REFERER, ";
    $sql.= "SESSIONS.USER_AGENT, SESSIONS.FID, UNIX_TIMESTAMP(SESSIONS.TIME) AS TIME, ";
    $sql.= "UNIX_TIMESTAMP(USER.APPROVED) AS APPROVED, USER.LOGON, USER.NICKNAME, ";
    $sql.= "USER.EMAIL, USER.PASSWD FROM SESSIONS LEFT JOIN USER ON (USER.UID = SESSIONS.UID) ";
    $sql.= "WHERE SESSIONS.HASH = '$sess_hash'";
    
    if (!$result = db_query($sql, $db_session_get)) return false;

    if (db_num_rows($result) == 0) return false;
    
    if (!($user_sess = db_fetch_array($result, DB_RESULT_ASSOC))) return false;
    
    if (($user_prefs = user_get_prefs($user_sess['UID']))) {
        $user_sess = array_merge($user_sess, $user_prefs);
    }    
    
    if (($user_perms = session_get_perm_array($user_sess['UID'], $forum_fid))) {
        $user_sess['PERMS'] = $user_perms;
    }

    if (isset($user_prefs['STYLE'])) {
        html_set_cookie("forum_style", $user_prefs['STYLE'], time() + YEAR_IN_SECONDS);
    }
    
    $user_sess['RAND_HASH'] = md5(uniqid(mt_rand()));

    if (!is_numeric($user_sess['FID'])) $user_sess['FID'] = 0;
    
    return $user_sess;    
}

/**
 * Restore a saved session
 * 
 * Restore or reinitialise a session started 
 * with "remember me" login option.
 * 
 * @param void
 * @return mixed
 */
function session_restore()
{
    if (!($user_logon = html_get_cookie('user_logon'))) return false;

    if (!($user_token = html_get_cookie('user_token'))) return false;

    if (!($uid = user_logon_token($user_logon, $user_token))) return false;
    
    html_set_cookie('user_logon', $user_logon, time() + YEAR_IN_SECONDS);
    html_set_cookie('user_token', $user_token, time() + YEAR_IN_SECONDS);
    
    if (!($sess_hash = session_init($uid))) return false;
    
    return $sess_hash;
}

/**
 * Update a session
 * 
 * Updates a session to ensure it contains up to date
 * information about the user, including IP address,
 * which forum they are visiting and the last time
 * they viewed a page (within cut-off)
 * 
 * @param mixed $user_sess
 * @return bool
 */
function session_update($user_sess)
{
    if (!$db_session_update = db_connect()) return false;
    
    if (!$ipaddress = get_ip_address()) return false;
    
    if (($table_data = get_table_prefix())) {
        $forum_fid = $table_data['FID'];
    }else {
        $forum_fid = 0;
    }    
    
    $active_sess_cutoff = intval(forum_get_setting('active_sess_cutoff', false, 900));
    
    if (((time() - $user_sess['TIME']) > $active_sess_cutoff) || ($user_sess['FID'] != $forum_fid)) {

        if ($user_sess['FID'] != $forum_fid) {

            session_update_visitor_log($user_sess['UID'], $forum_fid);

            forum_update_last_visit($user_sess['UID']);
        }
        
        $sess_hash = db_escape_string($user_sess['HASH']);
        
        $ipaddress = db_escape_string($ipaddress);
        
        $current_datetime = date(MYSQL_DATETIME, time());

        $sql = "UPDATE LOW_PRIORITY SESSIONS SET FID = '$forum_fid', ";
        $sql.= "TIME = CAST('$current_datetime' AS DATETIME), ";
        $sql.= "IPADDRESS = '$ipaddress' WHERE HASH = '$sess_hash'";

        if (!$result = db_query($sql, $db_session_update)) return false;

        session_update_user_time($user_sess['UID']);
    }
    
    return true;    
}

/**
 * Checks the current user's session is valid.
 *
 * Check that the current user's session is valid. 
 * If successfully returns the user's session as 
 * an array. If the user's session has expired
 * they are redirected to a page to re-initialise
 * the session.
 *
 * @param bool $show_session_fail
 * @param bool $init_guest_session
 * @return mixed
 */
function session_check($show_session_fail = true, $init_guest_session = true)
{
    static $user_sess = false;
    
    if (!is_array($user_sess)) {
    
        if (!$db_session_check = db_connect()) return false;

        if (!$ipaddress = get_ip_address()) return false;
        
        if (!($sess_hash = html_get_cookie('sess_hash'))) {
            $sess_hash = session_restore();
        }
        
        if (!($user_sess = session_get($sess_hash))) {
            
            if (is_md5($sess_hash) && $show_session_fail) {
                session_expired();
            }

            if (!$init_guest_session) return false;
            
            $sess_hash = md5($ipaddress);
            
            if (!($user_sess = session_get($sess_hash))) {
        
                if (!($sess_hash = session_init(0))) return false;
            
                if (!($user_sess = session_get($sess_hash))) return false;
            }
        }
    }
    
    session_update($user_sess);
    
    ban_check($user_sess);

    forum_check_maintenance();

    return $user_sess;
}

/**
 * Initialises a user session.
 *
 * Initialises a user session by constructing a 
 * unique MD5 hash and assigning the hash to the 
 * user's UID and setting a cookie. Returns
 * session hash on success of false on failure.
 *
 * @param integer $uid
 * @param bool $update_visitor_log
 * @param bool $skip_cookie
 * @return mixed
 */
function session_init($uid, $update_visitor_log = true, $skip_cookie = false)
{
    if (!$db_session_init = db_connect()) return false;

    if (!is_numeric($uid)) return false;

    if (!$ipaddress = get_ip_address()) return false;

    if (($table_data = get_table_prefix())) {
        $forum_fid = $table_data['FID'];
    }else {
        $forum_fid = 0;
    }

    $sess_hash = ($uid == 0) ? md5($ipaddress) : md5(uniqid(mt_rand()));

    $current_datetime = date(MYSQL_DATETIME, time());

    $http_referer = db_escape_string(session_get_referer());
    
    $http_user_agent = db_escape_string(session_get_user_agent());

    $http_referer = db_escape_string($http_referer);

    $ipaddress = db_escape_string($ipaddress);
    
    $search_id = session_is_search_engine();
    
    $sql = "INSERT INTO SESSIONS (HASH, UID, FID, IPADDRESS, TIME, REFERER, USER_AGENT, SID) ";
    $sql.= "VALUES ('$sess_hash', '$uid', '$forum_fid', '$ipaddress', CAST('$current_datetime' AS DATETIME), ";
    $sql.= "'$http_referer', '$http_user_agent', '$search_id') ON DUPLICATE KEY ";
    $sql.= "UPDATE FID = VALUES(FID), TIME = VALUES(TIME), IPADDRESS = VALUES(IPADDRESS), ";
    $sql.= "REFERER = VALUES(REFERER), USER_AGENT = VALUES(USER_AGENT), SID = VALUES(SID)";

    if (!db_query($sql, $db_session_init)) return false;

    if ($update_visitor_log === true) {
        
        session_update_visitor_log($uid, $forum_fid);

        forum_update_last_visit($uid);
    }

    if ($skip_cookie === false) {
        html_set_cookie("sess_hash", $sess_hash);
    }

    return $sess_hash;
}

/**
 * Display session expired message
 * 
 * Displays a HTML message to the user indicating
 * that their session has expired, i.e. they have
 * a cookie but we no longer have a record that
 * matches it.
 * 
 * @param void
 * @return void
 */
function session_expired()
{
    $webtag = get_webtag();

    $lang = load_language_file();

    if (defined("BEEHIVEMODE_LIGHT")) {

        $final_uri = rawurlencode(get_request_uri());
        header_redirect("llogon.php?webtag=$webtag&final_uri=$final_uri");
    }

    cache_disable();

    html_draw_top('logon.js');

    if (isset($_POST['logon']) || isset($_POST['guest_logon'])) {

        if (logon_perform()) {

            unset($_POST['user_logon'], $_POST['user_password'], $_POST['logon'], $_POST['webtag'], $_POST['register']);

            $request_uri = get_request_uri(true, false);

            if ((isset($_POST) && is_array($_POST) && sizeof($_POST) > 0)) {

                html_draw_top('logon.js');

                echo "<h1>{$lang['loggedinsuccessfully']}</h1>";

                html_display_warning_msg($lang['presscontinuetoresend'], '600', 'center');

                echo "<div align=\"center\">\n";

                if (stristr($request_uri, 'logon.php')) {

                    echo "<form accept-charset=\"utf-8\" method=\"post\" action=\"$request_uri\" target=\"", html_get_top_frame_name(), "\">\n";

                }else {

                    echo "<form accept-charset=\"utf-8\" method=\"post\" action=\"$request_uri\" target=\"_self\">\n";
                }

                echo form_input_hidden('webtag', htmlentities_array($webtag));

                echo form_input_hidden_array(stripslashes_array($_POST));

                echo form_submit('continue', $lang['continue']), "&nbsp;";
                echo "<a href=\"$request_uri\" class=\"button\"><span>{$lang['cancel']}</span></a>\n";
                echo "</form>\n";
                echo "</div>\n";

                html_draw_bottom();
                exit;

            }else {

                header_redirect($request_uri, $lang['loggedinsuccessfully']);
                exit;
            }

        }else {

            html_display_error_msg($lang['usernameorpasswdnotvalid'], '500', 'center');
        }

    }else {

        html_display_error_msg($lang['yoursessionhasexpired'], '500', 'center');
    }

    echo "<div align=\"center\">\n";

    logon_draw_form(LOGON_FORM_SESSION_EXPIRED);

    echo "</div>\n";

    html_draw_bottom();
    exit;
}

/**
 * Fetch a value from the user session
 *
 * Fetches a named value from the user session for the current user.
 * If value being fetches is 'UID' and the setting is not set for
 * the user 0 is returned, otherwise false.
 *
 * @param string $session_key
 * @return mixed
 */
function session_get_value($session_key)
{
    $user_sess = (isset($GLOBALS['user_sess'])) ? $GLOBALS['user_sess'] : false;

    if (is_array($user_sess) && isset($user_sess[$session_key])) {
        return $user_sess[$session_key];
    }

    if (mb_strtoupper($session_key) == 'UID') return 0;

    return false;
}

/**
 * Delete expired sessions
 *
 * Automatically remove any sessions which have been idle longer than the time out
 * value specified in the Forum's session_cutoff setting.
 *
 * @param void
 * @return void
 */
function remove_stale_sessions()
{
    if (!$db_remove_stale_sessions = db_connect()) return false;

    if (!($session_cutoff = forum_get_setting('session_cutoff', false, 86400))) {
        return true;
    }

    $session_cutoff_datetime = date(MYSQL_DATE_HOUR_MIN, time() - $session_cutoff);

    $sql = "DELETE QUICK FROM SESSIONS WHERE UID = 0 AND ";
    $sql.= "TIME < CAST('$session_cutoff_datetime' AS DATETIME) ";

    if (!db_query($sql, $db_remove_stale_sessions)) return false;

    $expired_sessions_array = array();

    $sql = "SELECT HASH FROM SESSIONS WHERE ";
    $sql.= "TIME < CAST('$session_cutoff_datetime' AS DATETIME) ";
    $sql.= "AND UID > 0 LIMIT 0, 5";

    if (!$result = db_query($sql, $db_remove_stale_sessions)) return false;

    if (db_num_rows($result) < 1) return false;

    while (($session_data = db_fetch_array($result))) {
        $expired_sessions_array[] = $session_data['HASH'];
    }

    $expired_sessions = implode("', '", $expired_sessions_array);

    $sql = "DELETE QUICK FROM SESSIONS WHERE HASH IN ('$expired_sessions') ";
    $sql.= "AND TIME < CAST('$session_cutoff_datetime' AS DATETIME) ";

    if (!$result = db_query($sql, $db_remove_stale_sessions)) return false;

    return true;
}

/**
 * Updates the visitor log
 *
 * Updates the visitor log for the specified UID.
 *
 * @param integer $uid
 * @return bool
 */
function session_update_visitor_log($uid, $forum_fid)
{
    if (!$db_session_update_visitor_log = db_connect()) return false;

    if (!is_numeric($uid)) return false;

    if (!is_numeric($forum_fid)) return false;
    
    if (!$ipaddress = get_ip_address()) return false;

    $http_referer = db_escape_string(session_get_referer());
    
    $http_user_agent = db_escape_string(session_get_user_agent());

    $ipaddress = db_escape_string($ipaddress);

    $current_datetime = date(MYSQL_DATETIME, time());
    
    $search_id = session_is_search_engine();

    $sql = "INSERT INTO VISITOR_LOG (FORUM, UID, LAST_LOGON, IPADDRESS, REFERER, USER_AGENT, SID) ";
    $sql.= "VALUES ('$forum_fid', '$uid', CAST('$current_datetime' AS DATETIME), '$ipaddress', ";
    $sql.= "'$http_referer', '$http_user_agent', '$search_id') ON DUPLICATE KEY UPDATE ";
    $sql.= "FORUM = VALUES(FORUM), LAST_LOGON = CAST('$current_datetime' AS DATETIME), ";
    $sql.= "IPADDRESS = VALUES(IPADDRESS), REFERER = VALUES(REFERER), USER_AGENT = VALUES(USER_AGENT), ";
    $sql.= "SID = VALUES(SID)";

    if (!db_query($sql, $db_session_update_visitor_log)) return false;

    return true;
}

/**
 * Updates user's session statistics
 *
 * Updates the total time spent logged in and longest session time.
 *
 * @param int $uid
 * @return bool
 */
function session_update_user_time($uid)
{
    if (!is_numeric($uid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    if (!$db_session_update_user_time = db_connect()) return false;

    $sql = "INSERT INTO `{$table_data['PREFIX']}USER_TRACK` (UID, USER_TIME_BEST) ";
    $sql.= "SELECT USER_FORUM.UID, FROM_UNIXTIME(UNIX_TIMESTAMP(SESSIONS.TIME) - UNIX_TIMESTAMP(USER_FORUM.LAST_VISIT)) ";
    $sql.= "FROM SESSIONS LEFT JOIN USER_FORUM ON (USER_FORUM.UID = SESSIONS.UID AND USER_FORUM.FID = SESSIONS.FID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_TRACK` USER_TRACK ON (USER_TRACK.UID = USER_FORUM.UID) ";
    $sql.= "WHERE SESSIONS.UID = '$uid' AND SESSIONS.FID = '$forum_fid' AND ((SESSIONS.TIME > USER_FORUM.LAST_VISIT ";
    $sql.= "AND (UNIX_TIMESTAMP(SESSIONS.TIME) - UNIX_TIMESTAMP(USER_FORUM.LAST_VISIT)) > UNIX_TIMESTAMP(USER_TRACK.USER_TIME_BEST)) ";
    $sql.= "OR USER_TRACK.USER_TIME_BEST IS NULL) ON DUPLICATE KEY UPDATE USER_TIME_BEST = VALUES(USER_TIME_BEST)";

    if (!db_query($sql, $db_session_update_user_time)) return false;

    $sql = "INSERT INTO `{$table_data['PREFIX']}USER_TRACK` (UID, USER_TIME_TOTAL, USER_TIME_UPDATED) ";
    $sql.= "SELECT UID, FROM_UNIXTIME(USER_TIME_TOTAL + (TIME_END - TIME_START)) AS USER_TIME_TOTAL, ";
    $sql.= "FROM_UNIXTIME(TIME_END) AS USER_TIME_UPDATED FROM (SELECT UID, USER_TIME_TOTAL, ";
    $sql.= "IF (USER_TIME_UPDATED >= LAST_VISIT, USER_TIME_UPDATED, LAST_VISIT) AS TIME_START, ";
    $sql.= "IF (SESSION_TIME >= USER_TIME_UPDATED, SESSION_TIME, USER_TIME_UPDATED) AS TIME_END ";
    $sql.= "FROM (SELECT USER_FORUM.UID, COALESCE(UNIX_TIMESTAMP(USER_TRACK.USER_TIME_UPDATED), 0) AS USER_TIME_UPDATED, ";
    $sql.= "COALESCE(UNIX_TIMESTAMP(USER_FORUM.LAST_VISIT), 0) AS LAST_VISIT, COALESCE(UNIX_TIMESTAMP(SESSIONS.TIME), 0) AS SESSION_TIME, ";
    $sql.= "COALESCE(UNIX_TIMESTAMP(USER_TRACK.USER_TIME_TOTAL), 0) AS USER_TIME_TOTAL FROM SESSIONS ";
    $sql.= "INNER JOIN USER_FORUM ON (USER_FORUM.UID = SESSIONS.UID AND USER_FORUM.FID = SESSIONS.FID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_TRACK` USER_TRACK ON (USER_TRACK.UID = USER_FORUM.UID) ";
    $sql.= "WHERE SESSIONS.UID = '$uid' AND SESSIONS.FID = '$forum_fid') AS USER_TIMES) AS TIME_COMPARE ";
    $sql.= "ON DUPLICATE KEY UPDATE USER_TIME_TOTAL = VALUES(USER_TIME_TOTAL), ";
    $sql.= "USER_TIME_UPDATED = VALUES(USER_TIME_UPDATED)";

    if (!db_query($sql, $db_session_update_user_time)) return false;

    return true;
}

/**
 * Ends current user session.
 *
 * Ends session for current logged in user by destroying their cookie.
 * DOES NOT remove the data from the SESSION table.
 *
 * @param void
 * @return void
 */
function session_remove_cookies()
{
    $webtag = get_webtag();

    // Unset the session cookies.
    html_set_cookie("sess_hash", "", time() - YEAR_IN_SECONDS);

    // Unset the forum password cookie if any.
    if (forum_check_webtag_available($webtag)) {
        html_set_cookie("sess_hash_{$webtag}", "", time() - YEAR_IN_SECONDS);
    }
}

/**
 * Ends current user session.
 *
 * Ends session for current logged in user by destroying their cookie.
 * and removing the data from the SESSION table.
 *
 * @param void
 * @return bool
 */
function session_end($remove_cookies = true)
{
    if (!$db_session_end = db_connect()) return false;

    if (!$ipaddress = get_ip_address()) return false;

    $sess_hash = html_get_cookie('sess_hash', 'is_md5', md5($ipaddress));

    if (isset($sess_hash) && is_md5($sess_hash)) {

        if ($remove_cookies === true) {
            session_remove_cookies();
        }

        $sql = "DELETE QUICK FROM SESSIONS WHERE HASH = '$sess_hash'";

        if (!db_query($sql, $db_session_end)) return false;
    }

    return true;
}

/**
 * Returns user perm array from database
 *
 * Processes GROUP_PERM and GROUP_USERS tables to fetch the user's perm array
 * and return it as an indexed array in the format:
 *
 * $perm_array['FORUM_FID']['FOLDER_FID'] = PERM_VALUE;
 *
 * @param integer $uid
 * @param integer $forum_fid
 * @return mixed
 */
function session_get_perm_array($uid, $forum_fid)
{
    if (!$db_session_get_perm_array = db_connect()) return false;

    if (!is_numeric($uid)) return false;
    if (!is_numeric($forum_fid)) return false;
    
    if (!$table_data = forum_get_table_prefix($forum_fid)) return false;

    $user_perm_array = array();

    $sql = "SELECT FID, PERM, IF (PERM IS NULL, 0, 1) AS FOLDER_PERM_COUNT ";
    $sql.= "FROM `{$table_data['PREFIX']}FOLDER`";

    if (!$result = db_query($sql, $db_session_get_perm_array)) return false;

    if (db_num_rows($result) > 0) {

        while (($permission_data = db_fetch_array($result))) {

            if ($permission_data['FOLDER_PERM_COUNT'] > 0) {

                $user_perm_array[$forum_fid][$permission_data['FID']] = (double)$permission_data['PERM'];
            }
        }
    }

    $sql = "SELECT GROUP_PERMS.GID, GROUP_PERMS.FORUM, GROUP_PERMS.FID, ";
    $sql.= "BIT_OR(GROUP_PERMS.PERM) AS PERM, COUNT(GROUP_PERMS.GID) AS USER_PERM_COUNT ";
    $sql.= "FROM GROUP_USERS INNER JOIN GROUP_PERMS USING (GID) ";
    $sql.= "WHERE GROUP_USERS.UID = '$uid' AND GROUP_PERMS.FORUM IN (0, $forum_fid) ";
    $sql.= "GROUP BY GROUP_PERMS.FORUM, GROUP_PERMS.FID";

    if (!$result = db_query($sql, $db_session_get_perm_array)) return false;

    if (db_num_rows($result) > 0) {

        while (($permission_data = db_fetch_array($result))) {

            if ($permission_data['USER_PERM_COUNT'] > 0) {

                if (isset($user_perm_array[$permission_data['FORUM']][$permission_data['FID']])) {

                    if (($user_perm_array[$permission_data['FORUM']][$permission_data['FID']] & USER_PERM_THREAD_MOVE) > 0) {
                        $permission_data['PERM'] = (double)$permission_data['PERM'] | USER_PERM_THREAD_MOVE;
                    }
                }

                $user_perm_array[$permission_data['FORUM']][$permission_data['FID']] = (double)$permission_data['PERM'];
            }
        }
    }

    return sizeof($user_perm_array) > 0 ? $user_perm_array : false;
}

/**
 * Checks user perm array in current user session
 *
 * Checks the user session perms against the provided perm value.
 * See constants.inc.php for perm values to use.
 *
 * @param integer $perm
 * @param integer $folder_fid
 * @param integer $forum_fid
 * @return bool
 */
function session_check_perm($perm, $folder_fid, $forum_fid = false)
{
    $user_sess = (isset($GLOBALS['user_sess'])) ? $GLOBALS['user_sess'] : false;

    if (!is_array($user_sess)) return false;
    if (!is_numeric($folder_fid)) return false;

    if (!is_numeric($forum_fid)) {

        if (!$table_data = get_table_prefix()) {
            $forum_fid = 0;
        }else {
            $forum_fid = $table_data['FID'];
        }
    }

    $user_perm_test = 0;

    if (user_is_guest()) {

        if (isset($user_sess['PERMS'][$forum_fid][$folder_fid])) {
            $user_perm_test = $user_perm_test | $user_sess['PERMS'][$forum_fid][$folder_fid];
        }

    }else {

        if (isset($user_sess['PERMS'][$forum_fid][0])) {
            $user_perm_test = $user_perm_test | $user_sess['PERMS'][$forum_fid][0];
        }

        if (isset($user_sess['PERMS'][$forum_fid][$folder_fid])) {
            $user_perm_test = $user_perm_test | $user_sess['PERMS'][$forum_fid][$folder_fid];
        }

        if (isset($user_sess['PERMS'][0][0])) {
            $user_perm_test = $user_perm_test | $user_sess['PERMS'][0][0];
        }
    }

    return (($user_perm_test & $perm) == $perm);
}

/**
 * Get the user session current perm value.
 *
 * Gets the current perm value for the selected forum and folder.
 *
 * @param integer $folder_fid
 * @return integer
 */
function session_get_perm($folder_fid)
{
    $user_sess = (isset($GLOBALS['user_sess'])) ? $GLOBALS['user_sess'] : false;

    if (!is_array($user_sess)) return false;
    if (!is_numeric($folder_fid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    $user_perm_test = 0;

    if (user_is_guest()) {

        if (isset($user_sess['PERMS'][$forum_fid][$folder_fid])) {
            $user_perm_test = $user_perm_test | $user_sess['PERMS'][$forum_fid][$folder_fid];
        }

    }else {

        if (isset($user_sess['PERMS'][$forum_fid][$folder_fid])) {
            $user_perm_test = $user_perm_test | $user_sess['PERMS'][$forum_fid][$folder_fid];
        }

        if (isset($user_sess['PERMS'][0][$folder_fid])) {
            $user_perm_test = $user_perm_test | $user_sess['PERMS'][0][$folder_fid];
        }
    }

    return $user_perm_test;
}

/**
 * Check user is banned.
 *
 * Checks the current user session perms to see if the is banned. Checks both
 * the global and per-forum bans (even though it's currently only possible to
 * ban at the per-forum level)
 *
 * @param void
 * @return bool
 */
function session_user_banned()
{
    if (session_check_perm(USER_PERM_BANNED, 0)) {
        return true;
    }

    return false;
}

/**
 * Check to see if user has been approved to access the current forum.
 *
 * Checks the forum settings to see if user approval is enabled and that the user
 * has been approved. This setting applies only at the per-forum level. Users
 * awaiting approval can still access "My Forums", "PM Inbox" and login and out.
 *
 * @param void
 * @return bool
 */
function session_user_approved()
{
    if (user_is_guest()) return true;
    if (session_check_perm(USER_PERM_ADMIN_TOOLS, 0)) return true;

    if (forum_get_setting('require_user_approval', 'Y')) {

        $user_approved = session_get_value('APPROVED');
        return $user_approved > 0;
    }

    return true;
}

/**
 * Return an array of folder fids in the user session that match the provided permission.
 *
 * Iterates through the USER_PERMS array and finds folders that match the user permission
 * provided in $perm or false if no results.
 *
 * @param integer $perm
 * @param integer $forum_fid
 * @return mixed
 */
function session_get_folders_by_perm($perm, $forum_fid = false)
{
    if (!is_numeric($perm)) return false;

    $user_sess = (isset($GLOBALS['user_sess'])) ? $GLOBALS['user_sess'] : false;

    if (!isset($user_sess['UID'])) return false;

    if ($forum_fid === false) {

        if (!$table_data = get_table_prefix()) return false;

        $forum_fid = $table_data['FID'];
    }

    if (!isset($user_sess['PERMS'][$forum_fid])) {

        $user_sess['PERMS'][$forum_fid] = array();

        if (($user_perms = session_get_perm_array($user_sess['UID'], $forum_fid))) {
            $user_sess['PERMS'][$forum_fid] = $user_perms[$forum_fid];
        }
    }

    $folder_fid_array = array();

    // Global Permissions.
    if (isset($user_sess['PERMS'][$forum_fid][0])) {
        $global_user_perms = $user_sess['PERMS'][$forum_fid][0];
    }else {
        $global_user_perms = 0;
    }

    // Test each folder against the provided perm at both the folder
    // user and global user permission levels.
    if (isset($user_sess['PERMS'][$forum_fid]) && is_array($user_sess['PERMS'][$forum_fid])) {

        foreach ($user_sess['PERMS'][$forum_fid] as $folder_fid => $folder_perm) {

            if (($folder_perm & $perm) == $perm || ($global_user_perms & $perm) == $perm) {

                $folder_fid_array[$folder_fid] = $folder_fid;
            }
        }
    }

    return sizeof($folder_fid_array) > 0 ? $folder_fid_array : false;
}

/**
 * Fetches user's post page preference
 *
 * Fetches the user's post page (POST_PAGE) setting from their user preferences.
 * If no user preference is available it returns a default value of 3271 which
 * includes:
 *
 * POST_TOOLBAR_DISPLAY
 * POST_EMOTICONS_DISPLAY
 * POST_TEXT_DEFAULT
 * POST_AUTO_LINKS
 * POST_SIGNATURE_DISPLAY
 * POLL_ADVANCED_DISPLAY
 * POLL_ADDITIONAL_MESSAGE_DISPLAY
 *
 * @param void
 * @return int
 */
function session_get_post_page_prefs()
{
    if (!$page_prefs = session_get_value('POST_PAGE')) {

        $page_prefs = (double)POST_TOOLBAR_DISPLAY | POST_EMOTICONS_DISPLAY | POST_TEXT_DEFAULT | POST_AUTO_LINKS;
        $page_prefs = (double)$page_prefs | POST_SIGNATURE_DISPLAY | POLL_ADVANCED_DISPLAY | POLL_ADDITIONAL_MESSAGE_DISPLAY;
    }

    return $page_prefs;
}

/**
 * Determine if session belongs to search engine
 * 
 * Queries the HTTP_USER_AGENT against a list of known
 * Search Engine bots and returns a unique ID if a
 * match is found.
 * 
 * @param void
 * @return mixed
 */
function session_is_search_engine()
{
    if (!$db_session_is_search_engine = db_connect()) return false;

    if (isset($_SERVER['HTTP_USER_AGENT']) && strlen(trim($_SERVER['HTTP_USER_AGENT'])) > 0) {

        $http_user_agent = db_escape_string($_SERVER['HTTP_USER_AGENT']);

        $sql = "SELECT SID FROM SEARCH_ENGINE_BOTS ";
        $sql.= "WHERE  '$http_user_agent' LIKE AGENT_MATCH ";

        if (!$result = db_query($sql, $db_session_is_search_engine)) return false;

        if (db_num_rows($result) > 0) {

            list($search_engine_id) = db_fetch_array($result, DB_RESULT_NUM);
            return $search_engine_id;
        }
    }

    return false;
}

/**
 * Get HTTP referrer
 * 
 * Get the HTTP referer that was used to initialise
 * a session. If the session does not contain an existing
 * referer, it is determined from the HTTP headers.
 * 
 * @param void
 * @return string
 */
function session_get_referer()
{
    if (($http_referer = session_get_value('REFERER')) === false) {

        if (isset($_SERVER['HTTP_REFERER']) && strlen(trim($_SERVER['HTTP_REFERER'])) > 0) {

            $http_referer = trim($_SERVER['HTTP_REFERER']);
            $forum_uri_preg = preg_quote(html_get_forum_uri(), '/');

            if (preg_match("/^$forum_uri_preg/iu", $http_referer) > 0) $http_referer = "";

        }else {

            $http_referer = "";
        }
    }

    return $http_referer;
}

/**
 * Get HTTP user agent
 * 
 * Get the HTTP user agent that was used to initialise
 * a session. If the session does not contain an existing
 * user agent, it is determined from the HTTP headers.
 * 
 * @param void
 * @return string
 */
function session_get_user_agent()
{
    if (($http_referer = session_get_value('USER_AGENT')) === false) {

        if (isset($_SERVER['HTTP_USER_AGENT']) && strlen(trim($_SERVER['HTTP_USER_AGENT'])) > 0) {

            return $_SERVER['HTTP_USER_AGENT'];

        } else {

            $http_referer = "";
        }
    }

    return $http_referer;
}

?>