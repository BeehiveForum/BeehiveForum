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

/* $Id: session.inc.php,v 1.392 2009-10-03 19:43:17 decoyduck Exp $ */

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
include_once(BH_INCLUDE_PATH. "compat.inc.php");
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

// Checks the session and returns it as an array.

/**
* Checks the current user's session is valid.
*
* Check that the current user's session is valid. If successfully returns the user's session
* as an array, otherwise a variety of outcomes is possible. If the user's session has expired
* they are redirected to a page to re-initialise the session.
*
* @return mixed - array on success, false on fail
* @param string $show_session_fail - Disable the default behaviour of showing the session expired page.
*/

function bh_session_check($show_session_fail = true)
{
    if (!$db_bh_session_check = db_connect()) return false;

    // Fetch the user's IP Address

    if (!$ipaddress = get_ip_address()) return false;

    // Session cut off timestamp

    $active_sess_cutoff = intval(forum_get_setting('active_sess_cutoff', false, 900));

    // Check to see if we have a session cookie.

    $user_hash = bh_getcookie('bh_sess_hash', 'is_md5');

    $ipaddress = db_escape_string($ipaddress);

    // Check for a webtag and get the forum FID.

    if (($table_data = get_table_prefix())) {
        $forum_fid = $table_data['FID'];
    }else {
        $forum_fid = 0;
    }
    
    $current_datetime = date(MYSQL_DATETIME, time());

    // Check the current user's session data. This is the main session
    // data that Beehive relies on. If this data does not match what
    // we have stored in the database then the user gets logged out
    // automatically.

    if (isset($user_hash) && is_md5($user_hash)) {

        $sql = "SELECT SESSIONS.HASH, SESSIONS.UID, SESSIONS.IPADDRESS, SESSIONS.REFERER, SESSIONS.FID, ";
        $sql.= "UNIX_TIMESTAMP(SESSIONS.TIME) AS TIME, UNIX_TIMESTAMP(USER.APPROVED) AS APPROVED, ";
        $sql.= "USER.LOGON, USER.NICKNAME, USER.EMAIL,USER.PASSWD FROM SESSIONS ";
        $sql.= "LEFT JOIN USER ON (USER.UID = SESSIONS.UID) WHERE SESSIONS.HASH = '$user_hash' ";
        $sql.= "AND SESSIONS.IPADDRESS = '$ipaddress'";

        if (!$result = db_query($sql, $db_bh_session_check)) return false;

        if (db_num_rows($result) > 0) {

            // Fetch the session data from the database

            $user_sess = db_fetch_array($result, DB_RESULT_ASSOC);

            // If the session belongs to a guest pass control to bh_guest_session_init();

            if ($user_sess['UID'] == 0) return bh_guest_session_init();

            // check to see if the user's credentials match the
            // ban data set up on this forum.

            ban_check($user_sess);

            // Add preference settings

            if (($user_prefs = user_get_prefs($user_sess['UID']))) {
                $user_sess = array_merge($user_sess, $user_prefs);
            }

            // Add user perms

            if (($user_perms = bh_session_get_perm_array($user_sess['UID']))) {
                $user_sess['PERMS'] = $user_perms;
            }

            // A unique MD5 has for some purposes (word filter, etc)

            $user_sess['RAND_HASH'] = md5(uniqid(mt_rand()));

            // Check the forum FID the user is currently visiting

            if (!is_numeric($user_sess['FID'])) $user_sess['FID'] = 0;

            // Save a cookie for the forum style

            if (($forum_webtag = forum_get_webtag($user_sess['FID'])) && isset($user_prefs['STYLE'])) {
                bh_setcookie("bh_{$forum_webtag}_style", $user_prefs['STYLE'], time() + YEAR_IN_SECONDS);
            }
            
            // Check the session time. If it is higher than 'active_sess_cutoff'
            // or the user has changed forums we should update the user's session data.

            if (((time() - $user_sess['TIME']) > $active_sess_cutoff) || ($user_sess['FID'] != $forum_fid)) {

                // Update the user time stats before we update the session

                bh_update_user_time($user_sess['UID']);

                // Update the session time and forum FID.

                $sql = "UPDATE LOW_PRIORITY SESSIONS SET FID = '$forum_fid', ";
                $sql.= "TIME = CAST('$current_datetime' AS DATETIME) ";
                $sql.= "WHERE HASH = '$user_hash' AND IPADDRESS = '$ipaddress'";

                if (!$result = db_query($sql, $db_bh_session_check)) return false;

                // If the user has changed forums we should call bh_update_visitor_log 
                // and forum_update_last_visit()

                if ($user_sess['FID'] != $forum_fid) {

                    bh_update_visitor_log($user_sess['UID'], $forum_fid);
                    forum_update_last_visit($user_sess['UID']);
                }
                
                // Forum self-preservation

                forum_check_maintenance();                
            }

            // Return session data

            return $user_sess;

        }elseif ($show_session_fail) {

            bh_session_expired();
        }
    }

    return bh_guest_session_init();
}

function bh_session_expired()
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

            logon_unset_post_data();

            $request_uri = get_request_uri(true, false);

            if ((isset($_POST) && is_array($_POST) && sizeof($_POST) > 0) && !user_is_guest()) {

                html_draw_top('logon.js');

                echo "<h1>{$lang['loggedinsuccessfully']}</h1>";

                $top_html = html_get_top_page();

                echo "<script language=\"Javascript\" type=\"text/javascript\">\n";
                echo "<!--\n\n";
                echo "if (top.document.body.rows) {\n\n";
                echo "    top.frames['", html_get_frame_name('ftop'), "'].location.replace('$top_html');\n";
                echo "    top.frames['", html_get_frame_name('fnav'), "'].location.reload();\n";
                echo "}\n\n";
                echo "-->\n";
                echo "</script>";

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
                echo form_button('cancel', $lang['cancel'], "onclick=\"self.location.href='$request_uri'\""), "\n";
                echo "</form>\n";
                echo "</div>\n";

                html_draw_bottom();
                exit;

            }else {

                if (!stristr($request_uri, 'reload_frames')) {
                    $request_uri = "{$request_uri}&reload_frames";
                }

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

function bh_guest_session_init()
{
    if (!$db_bh_guest_session_init = db_connect()) return false;

    if (!$ipaddress = get_ip_address()) return false;

    // Session cut off timestamp

    $active_sess_cutoff = intval(forum_get_setting('active_sess_cutoff', false, 900));

    // Check to see if we have a session cookie.

    $user_hash = bh_getcookie('bh_sess_hash', 'is_md5', md5($ipaddress));

    $ipaddress = db_escape_string($ipaddress);
    
    $current_datetime = date(MYSQL_DATETIME, time());

    if (user_guest_enabled()) {

        // Guest user sessions are handled a bit differently.
        // Rather than the cookie which holds their HASH we
        // keep track of guest sessions based on the user's IP
        // address. Of course this means that the guest counter
        // will be out if there is more than one guest coming
        // from a single IP address.

        if (($table_data = get_table_prefix())) {
            $forum_fid = $table_data['FID'];
        }else {
            $forum_fid = 0;
        }

        $sql = "SELECT HASH, 0 AS UID, UNIX_TIMESTAMP(SESSIONS.TIME) AS TIME, ";
        $sql.= "FID, IPADDRESS, 'GUEST' AS LOGON, MD5('GUEST') AS PASSWD, REFERER ";
        $sql.= "FROM SESSIONS WHERE HASH = '$user_hash' AND IPADDRESS = '$ipaddress'";

        if (!$result = db_query($sql, $db_bh_guest_session_init)) return false;

        if (db_num_rows($result) > 0) {

            $user_sess = db_fetch_array($result);

            // Add user perms

            if (($user_perms = bh_session_get_perm_array($user_sess['UID']))) {
                $user_sess['PERMS'] = $user_perms;
            }

            // A unique MD5 has for some purposes (word filter, etc)

            $user_sess['RAND_HASH'] = md5(uniqid(mt_rand()));

            // Check the forum FID the user is currently visiting

            if (!is_numeric($user_sess['FID'])) $user_sess['FID'] = 0;

            // Check the session time. If it is higher than 'active_sess_cutoff'
            // or the user has changed forums we should update the user's session data.

            if (((time() - $user_sess['TIME']) > $active_sess_cutoff) || $user_sess['FID'] != $forum_fid) {

                if ($user_sess['FID'] != $forum_fid) {

                    $sql = "UPDATE LOW_PRIORITY SESSIONS SET FID = '$forum_fid', ";
                    $sql.= "TIME = CAST('$current_datetime' AS DATETIME) ";
                    $sql.= "WHERE HASH = '$user_hash' AND IPADDRESS = '$ipaddress'";

                    if (!$result = db_query($sql, $db_bh_guest_session_init)) return false;

                    bh_update_visitor_log(0, $forum_fid);

                }else {

                    $sql = "UPDATE LOW_PRIORITY SESSIONS SET TIME = CAST('$current_datetime' AS DATETIME) ";
                    $sql.= "WHERE HASH = '$user_hash' AND IPADDRESS = '$ipaddress'";

                    if (!$result = db_query($sql, $db_bh_guest_session_init)) return false;
                }

                // Forum self-preservation

                forum_check_maintenance();                
            }

        }else {

            // HTTP referer

            $http_referer = bh_session_get_referer();

            // Session array of default values.

            $user_sess = array('UID'         => 0,
                               'TIME'        => time(),
                               'SERVER_TIME' => time(),
                               'LOGON'       => 'GUEST',
                               'PASSWD'      => md5('GUEST'),
                               'FID'         => $forum_fid,
                               'IPADDRESS'   => $ipaddress,
                               'REFERER'     => $http_referer,
                               'RAND_HASH'   => md5(uniqid(mt_rand())));

            // Add user perms

            if (($user_perms = bh_session_get_perm_array($user_sess['UID']))) {
                $user_sess['PERMS'] = $user_perms;
            }

            // HTTP Referer.

            $http_referer = db_escape_string($http_referer);

            // Start a session for the new guest user
            
            if (($search_id = bh_session_is_search_engine()) !== false) {

                $sql = "INSERT INTO SESSIONS (HASH, UID, FID, IPADDRESS, TIME, REFERER, SID) ";
                $sql.= "VALUES ('$user_hash', 0, $forum_fid, '$ipaddress', CAST('$current_datetime' AS DATETIME), ";
                $sql.= "'$http_referer', '$search_id') ON DUPLICATE KEY UPDATE FID = VALUES(FID), TIME = VALUES(TIME), ";
                $sql.= "IPADDRESS = VALUES(IPADDRESS), REFERER = VALUES(REFERER), SID = VALUES(SID)";

                if (!db_query($sql, $db_bh_guest_session_init)) return false;
            
            }else {
            
                $sql = "INSERT INTO SESSIONS (HASH, UID, FID, IPADDRESS, TIME, REFERER) ";
                $sql.= "VALUES ('$user_hash', 0, $forum_fid, '$ipaddress', CAST('$current_datetime' AS DATETIME), ";
                $sql.= "'$http_referer') ON DUPLICATE KEY UPDATE FID = VALUES(FID), TIME = VALUES(TIME), ";
                $sql.= "IPADDRESS = VALUES(IPADDRESS), REFERER = VALUES(REFERER)";

                if (!db_query($sql, $db_bh_guest_session_init)) return false;            
            }

            // Update visitor log.

            bh_update_visitor_log(0, $forum_fid);
        }

        // Check to see if the user's credentials match the
        // ban data set up on this forum.

        ban_check($user_sess, true);

        return $user_sess;
    }

    return false;
}

/**
* Checks if a session is active.
*
* Checks the user cookies and session to see if the current user is logged in.
*
* @return bool
* @param void
*/

function bh_session_active()
{
    if (bh_getcookie('bh_logon')) return false;
    if (bh_getcookie('bh_sess_hash')) return true;
    if (user_guest_enabled() && !user_cookies_set()) return true;

    return false;
}

/**
* Fetch a value from the user session
*
* Fetches a named value from the user session for the current user.
* If value being fetches is 'UID' and the setting is not set for
* the user 0 is returned, otherwise false.
*
* @return mixed
* @param string $session_key - Named key of the session variable to fetch.
*/

function bh_session_get_value($session_key)
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
* @return void
* @param void
*/

function bh_remove_stale_sessions()
{
    if (!$db_bh_remove_stale_sessions = db_connect()) return false;

    if (($session_cutoff = forum_get_setting('session_cutoff', false, 86400))) {

        $session_cutoff_datetime = date(MYSQL_DATE_HOUR_MIN, time() - $session_cutoff);
        
        $sql = "DELETE QUICK FROM SESSIONS WHERE UID = 0 AND ";
        $sql.= "TIME < CAST('$session_cutoff_datetime' AS DATETIME) ";

        if (!$result = db_query($sql, $db_bh_remove_stale_sessions)) return false;

        $expired_sessions_array = array();

        $sql = "SELECT HASH, UID FROM SESSIONS WHERE ";
        $sql.= "TIME < CAST('$session_cutoff_datetime' AS DATETIME) ";
        $sql.= "AND UID > 0 LIMIT 0, 5";

        if (!$result = db_query($sql, $db_bh_remove_stale_sessions)) return false;

        while (($session_data = db_fetch_array($result))) {

            bh_update_user_time($session_data['UID']);
            $expired_sessions_array[] = $session_data['HASH'];
        }

        if (sizeof($expired_sessions_array) > 0) {

            $expired_sessions = implode("', '", $expired_sessions_array);

            $sql = "DELETE QUICK FROM SESSIONS WHERE HASH IN ('$expired_sessions') ";
            $sql.= "AND TIME < CAST('$session_cutoff_datetime' AS DATETIME) ";

            if (!$result = db_query($sql, $db_bh_remove_stale_sessions)) return false;

            return true;
        }
    }

    return true;
}

// Updates the visitor log for the current user

/**
* Updates the visitor log
*
* Updates the visitor log for the specified UID.
*
* @return void
* @param integer $uid - UID of the user account we're updating the visitor log for.
*/

function bh_update_visitor_log($uid, $forum_fid)
{
    if (!$db_bh_update_visitor_log = db_connect()) return false;

    if (!is_numeric($uid)) return false;
    if (!is_numeric($forum_fid)) return false;

    if (!$ipaddress = get_ip_address()) return false;

    $session_cutoff = forum_get_setting('session_cutoff', false, 86400);

    $http_referer = db_escape_string(bh_session_get_referer());

    $ipaddress = db_escape_string($ipaddress);
    
    $session_cutoff_datetime = date(MYSQL_DATE_HOUR_MIN, time() - $session_cutoff);
    
    $current_datetime = date(MYSQL_DATETIME, time());
    
    if ($uid > 0) {

        $sql = "INSERT INTO VISITOR_LOG (FORUM, UID, VID, LAST_LOGON, IPADDRESS, REFERER) ";
        $sql.= "VALUES ('$forum_fid', '$uid', 1, CAST('$current_datetime' AS DATETIME), '$ipaddress', '$http_referer') ";
        $sql.= "ON DUPLICATE KEY UPDATE FORUM = VALUES(FORUM), LAST_LOGON = CAST('$current_datetime' AS DATETIME), ";
        $sql.= "IPADDRESS = VALUES(IPADDRESS), REFERER = VALUES(REFERER)";
        
        if (db_query($sql, $db_bh_update_visitor_log)) return true;

    }else {

        if (($search_id = bh_session_is_search_engine()) !== false) {
           
            $sql = "INSERT INTO VISITOR_LOG (FORUM, UID, VID, LAST_LOGON, IPADDRESS, REFERER, SID) ";
            $sql.= "VALUES ('$forum_fid', '$uid', 1, CAST('$current_datetime' AS DATETIME), '$ipaddress', '$http_referer', '$search_id') ";
            $sql.= "ON DUPLICATE KEY UPDATE FORUM = VALUES(FORUM), LAST_LOGON = CAST('$current_datetime' AS DATETIME), ";
            $sql.= "IPADDRESS = VALUES(IPADDRESS), REFERER = VALUES(REFERER), SID = VALUES(SID)";
            
            if (db_query($sql, $db_bh_update_visitor_log)) return true;

        }else if (!user_cookies_set() || isset($_POST['guest_logon'])) {
        
            $sql = "INSERT INTO VISITOR_LOG (FORUM, UID, LAST_LOGON, IPADDRESS, REFERER) ";
            $sql.= "VALUES ('$forum_fid', '$uid', CAST('$current_datetime' AS DATETIME), '$ipaddress', '$http_referer')";

            if (db_query($sql, $db_bh_update_visitor_log)) return true;        
        }
    }

    return false;
}

/**
* Updates user's session statistics
*
* Updates the total time spent logged in and longest session time.
*
* @return void
* @param integer $uid - UID of the user account we're updating.
*/

function bh_update_user_time($uid)
{
    if (!is_numeric($uid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    if (!$db_bh_update_user_time = db_connect()) return false;

    $sql = "INSERT INTO `{$table_data['PREFIX']}USER_TRACK` (UID, USER_TIME_BEST) ";
    $sql.= "SELECT USER_FORUM.UID, FROM_UNIXTIME(UNIX_TIMESTAMP(SESSIONS.TIME) - UNIX_TIMESTAMP(USER_FORUM.LAST_VISIT)) ";
    $sql.= "FROM SESSIONS INNER JOIN USER_FORUM ON (USER_FORUM.UID = SESSIONS.UID AND USER_FORUM.FID = SESSIONS.FID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_TRACK` USER_TRACK ON (USER_TRACK.UID = USER_FORUM.UID) ";
    $sql.= "WHERE SESSIONS.UID = '$uid' AND SESSIONS.FID = '$forum_fid' ";
    $sql.= "AND ((UNIX_TIMESTAMP(SESSIONS.TIME) - UNIX_TIMESTAMP(USER_FORUM.LAST_VISIT)) > UNIX_TIMESTAMP(USER_TRACK.USER_TIME_BEST) ";
    $sql.= "OR USER_TRACK.USER_TIME_BEST IS NULL) ON DUPLICATE KEY UPDATE USER_TIME_BEST = VALUES(USER_TIME_BEST)";

    if (!db_query($sql, $db_bh_update_user_time)) return false;

    $sql = "INSERT INTO `{$table_data['PREFIX']}USER_TRACK` (UID, USER_TIME_TOTAL, USER_TIME_UPDATED) ";
    $sql.= "SELECT USER_FORUM.UID, FROM_UNIXTIME(COALESCE(UNIX_TIMESTAMP(USER_TRACK.USER_TIME_TOTAL), 0) + ";
    $sql.= "(SESSIONS.TIME - COALESCE(USER_TRACK.USER_TIME_UPDATED, USER_FORUM.LAST_VISIT, SESSIONS.TIME))), SESSIONS.TIME ";
    $sql.= "FROM SESSIONS INNER JOIN USER_FORUM ON (USER_FORUM.UID = SESSIONS.UID AND USER_FORUM.FID = SESSIONS.FID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_TRACK` USER_TRACK ON (USER_TRACK.UID = USER_FORUM.UID) ";
    $sql.= "WHERE SESSIONS.UID = '$uid' AND SESSIONS.FID = '$forum_fid' ";
    $sql.= "ON DUPLICATE KEY UPDATE USER_TIME_TOTAL = VALUES(USER_TIME_TOTAL), ";
    $sql.= "USER_TIME_UPDATED = VALUES(USER_TIME_UPDATED)";

    if (!db_query($sql, $db_bh_update_user_time)) return false;

    return true;
}

/**
* Initialises a user session.
*
* Initialises a user session by constructing a unique MD5 hash and assigning
* the hash to the user's UID and setting a cookie.
*
* @return void
* @param integer $uid - UID of the user account we're initialising a session for.
* @param bool $update_visitor_log - Optionally update the visitor log if needed.
* @param bool $skip_cookie - Optionally skips setting of cookie if needed.
*/

function bh_session_init($uid, $update_visitor_log = true, $skip_cookie = false)
{
    if (!$db_bh_session_init = db_connect()) return false;

    if (!is_numeric($uid)) return false;

    if (!$ipaddress = get_ip_address()) return false;

    if (($table_data = get_table_prefix())) {
        $forum_fid = $table_data['FID'];
    }else {
        $forum_fid = 0;
    }

    $http_referer = bh_session_get_referer();

    $user_hash = md5($ipaddress);
    
    $current_datetime = date(MYSQL_DATETIME, time());

    $ipaddress = db_escape_string($ipaddress);
    
    // Delete any guest sessions this user might have.

    $sql = "DELETE QUICK FROM SESSIONS WHERE HASH = '$user_hash' ";
    $sql.= "AND IPADDRESS = '$ipaddress'";

    if (!db_query($sql, $db_bh_session_init)) return false;

    // Check for an existing user session.

    $sql = "SELECT HASH FROM SESSIONS WHERE UID = '$uid' ";
    $sql.= "AND IPADDRESS = '$ipaddress'";

    if (!$result = db_query($sql, $db_bh_session_init)) return false;

    if (db_num_rows($result) > 0) {

        list($user_hash) = db_fetch_array($result, DB_RESULT_NUM);

    }else {

        $user_hash = md5(uniqid(mt_rand()));

        $http_referer = db_escape_string($http_referer);
        
        if (($uid == 0) && ($search_id = bh_session_is_search_engine()) !== false) {

            $sql = "INSERT INTO SESSIONS (HASH, UID, FID, IPADDRESS, TIME, REFERER, SID) ";
            $sql.= "VALUES ('$user_hash', '$uid', '$forum_fid', '$ipaddress', CAST('$current_datetime' AS DATETIME), ";
            $sql.= "'$http_referer', '$search_id') ON DUPLICATE KEY UPDATE FID = VALUES(FID), TIME = VALUES(TIME), ";
            $sql.= "IPADDRESS = VALUES(IPADDRESS), REFERER = VALUES(REFERER), SID = VALUES(SID)";

            if (!db_query($sql, $db_bh_session_init)) return false;
        
        }else {
        
            $sql = "INSERT INTO SESSIONS (HASH, UID, FID, IPADDRESS, TIME, REFERER) ";
            $sql.= "VALUES ('$user_hash', '$uid', '$forum_fid', '$ipaddress', CAST('$current_datetime' AS DATETIME), ";
            $sql.= "'$http_referer') ON DUPLICATE KEY UPDATE FID = VALUES(FID), TIME = VALUES(TIME), ";
            $sql.= "IPADDRESS = VALUES(IPADDRESS), REFERER = VALUES(REFERER)";

            if (!db_query($sql, $db_bh_session_init)) return false;        
        }
    }

    if ($update_visitor_log === true) {

        bh_update_user_time($uid);

        bh_update_visitor_log($uid, $forum_fid);

        forum_update_last_visit($uid);
    }

    if ($skip_cookie === false) bh_setcookie("bh_sess_hash", $user_hash);

    return $user_hash;
}

/**
* Ends current user session.
*
* Ends session for current logged in user by destroying their cookie.
* DOES NOT remove the data from the SESSION table.
*
* @return void
* @param void
*/

function bh_session_remove_cookies()
{
    $webtag = get_webtag();

    // Unset the session cookies.

    bh_setcookie("bh_sess_hash", "", time() - YEAR_IN_SECONDS);
    bh_setcookie("bh_logon", "", time() - YEAR_IN_SECONDS);

    // Unset the forum password cookie if any.

    if (forum_check_webtag_available($webtag)) {
        bh_setcookie("bh_{$webtag}_sesshash", "", time() - YEAR_IN_SECONDS);
    }
}

/**
* Ends current user session.
*
* Ends session for current logged in user by destroying their cookie.
* and removing the data from the SESSION table.
*
* @return void
* @param void
*/

function bh_session_end($remove_cookies = true)
{
    if (!$db_bh_session_end = db_connect()) return false;

    if (($uid = bh_session_get_value('UID')) === false) return false;

    if (!$ipaddress = get_ip_address()) return false;

    // Session cookie

    $user_hash = bh_getcookie('bh_sess_hash', 'is_md5', md5($ipaddress));

    $ipaddress = db_escape_string($ipaddress);

    if (isset($user_hash) && is_md5($user_hash)) {

        // If the user isn't a guest we should update how long
        // they have been actively logged in.

        if ($uid > 0) bh_update_user_time($uid);

        // Delete the user's cookie

        if ($remove_cookies === true) bh_session_remove_cookies();

        // Remove the user session.

        $sql = "DELETE QUICK FROM SESSIONS WHERE HASH = '$user_hash' ";
        $sql.= "AND IPADDRESS = '$ipaddress'";

        if (!db_query($sql, $db_bh_session_end)) return false;
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
* @return mixed
* @param integer $uid - User UID.
*/

function bh_session_get_perm_array($uid)
{
    if (!$db_bh_session_get_perm_array = db_connect()) return false;

    if (!is_numeric($uid)) return false;

    $user_perm_array = array();

    if (($table_data = get_table_prefix())) {
        $forum_fid = $table_data['FID'];
    }else {
        $forum_fid = 0;
    }

    $sql = "SELECT GROUP_PERMS.GID, GROUP_PERMS.FORUM, GROUP_PERMS.FID, ";
    $sql.= "BIT_OR(GROUP_PERMS.PERM) AS PERM, COUNT(GROUP_PERMS.GID) AS USER_PERM_COUNT ";
    $sql.= "FROM GROUP_USERS INNER JOIN GROUPS ON (GROUPS.GID = GROUP_USERS.GID) ";
    $sql.= "LEFT JOIN GROUP_PERMS ON (GROUP_PERMS.GID = GROUP_USERS.GID ";
    $sql.= "AND GROUP_PERMS.FORUM IN (0, $forum_fid)) WHERE GROUP_USERS.UID = '$uid' ";
    $sql.= "GROUP BY GROUP_PERMS.FORUM, GROUP_PERMS.FID";

    if (!$result = db_query($sql, $db_bh_session_get_perm_array)) return false;

    if (db_num_rows($result) > 0) {

        while (($permission_data = db_fetch_array($result))) {

            if ($permission_data['USER_PERM_COUNT'] > 0) {

                $user_perm_array[$permission_data['FORUM']][$permission_data['FID']] = $permission_data['PERM'];
            }
        }
    }

    $sql = "SELECT FORUM, FID, BIT_OR(PERM) AS PERM FROM GROUP_PERMS ";
    $sql.= "WHERE GID = 0 AND FORUM IN (0, $forum_fid) GROUP BY FORUM, FID";

    if (!$result = db_query($sql, $db_bh_session_get_perm_array)) return false;

    if (db_num_rows($result) > 0) {

        while (($permission_data = db_fetch_array($result))) {

            if (!isset($user_perm_array[$permission_data['FORUM']][$permission_data['FID']])) {

                $user_perm_array[$permission_data['FORUM']][$permission_data['FID']] = $permission_data['PERM'];
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
* @return bool
* @param integer $perm - Perm value to check
* @param integer $folder_fid - FID of the folder to check.
* @param integer $forum_fid - Optional forum fid otherwise uses current forum FID.
*/

function bh_session_check_perm($perm, $folder_fid, $forum_fid = false)
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
* @return integer
* @param integer $folder_fid - FID of the folder to check.
* @param integer $forum_fid - Optional forum fid otherwise uses current forum FID.
*/

function bh_session_get_perm($folder_fid)
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
* @return bool - true if banned, false if not.
* @param void
*/

function bh_session_user_banned()
{
    if (bh_session_check_perm(USER_PERM_BANNED, 0)) {
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
* @return bool - true if approved or setting disabled, false if approval required.
* @param void
*/

function bh_session_user_approved()
{
    if (user_is_guest()) return true;
    if (bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0)) return true;

    if (forum_get_setting('require_user_approval', 'Y')) {

        $user_approved = bh_session_get_value('APPROVED');
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
* @return mixed - array on success, false on no results.
* @param integer $perm - Perm value to test (see constants.inc.php)
* @param integer $forum_fid = Optional forum fid otherwise  uses current forum FID.
*/

function bh_session_get_folders_by_perm($perm, $forum_fid = false)
{
    if (!is_numeric($perm)) return false;

    if ($forum_fid === false) {

        if (!$table_data = get_table_prefix()) return false;
        $forum_fid = $table_data['FID'];
    }

    $user_sess = (isset($GLOBALS['user_sess'])) ? $GLOBALS['user_sess'] : false;

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
* Parse an array into a string
*
* Parses an [multi-dimensional] array specified in $array into a string seperated by $sep.
*
* @return bool
* @param array $array - Array to parse
* @param string $sep - seperator to use to seperate array key and value pairs.
* @param string $result_var - By reference result variable which the result is appended to.
*/

function parse_array($array, $sep, &$result_var)
{
    if (!is_array($array)) return false;

    if (!is_string($result_var)) $result_var = "";
    if (!is_string($sep) || strlen($sep) < 1) $sep = "&";

    $array_keys = array();
    $array_values = array();

    flatten_array($array, $array_keys, $array_values);

    $result_array = array();

    foreach ($array_keys as $key => $key_name) {

        if (($key_name != 'webtag') && isset($array_values[$key])) {

            if (strlen($array_values[$key]) > 0) {

                $result_array[] = sprintf("%s=%s", $key_name, urlencode($array_values[$key]));

            }else {

                $result_array[] = $key_name;
            }
        }
    }

    $result_var.= implode($sep, $result_array);

    return true;
}

/**
* Return request URI
*
* IIS doesn't support the REQUEST_URI server var so we use this function to generate our own.
*
* @return string
* @param bool $encoded_uri_query - Specify whether or not we want URL encoded seperator in the URL (& vs. &amp;)
*/

function get_request_uri($include_webtag = true, $encoded_uri_query = true)
{
    if (!is_bool($include_webtag)) $include_webtag = true;
    if (!is_bool($encoded_uri_query)) $encoded_uri_query = true;

    $webtag = get_webtag();
    
    $query_string = "";

    forum_check_webtag_available($webtag);

    if ($encoded_uri_query) {

        if ($include_webtag) {

            $request_uri = "{$_SERVER['PHP_SELF']}?webtag=$webtag";
            parse_array($_GET, "&amp;", $query_string);
            
            if (strlen(trim($query_string)) > 0) {
                $request_uri.= "&amp;$query_string";
            }

        }else {

            $request_uri = "{$_SERVER['PHP_SELF']}";
            parse_array($_GET, "&amp;", $query_string);
            
            if (strlen(trim($query_string)) > 0) {
                $request_uri.= "?$query_string";
            }            
        }

    }else {

        if ($include_webtag) {

            $request_uri = "{$_SERVER['PHP_SELF']}?webtag=$webtag";
            parse_array($_GET, "&", $query_string);
            
            if (strlen(trim($query_string)) > 0) {
                $request_uri.= "&$query_string";
            }            

        }else {

            $request_uri = "{$_SERVER['PHP_SELF']}";
            parse_array($_GET, "&", $query_string);
            
            if (strlen(trim($query_string)) > 0) {
                $request_uri.= "?$query_string";
            }            
        }
    }

    // Fix the slashes for forum running from sub-domain.
    // Rather dirty hack this, but it's the only idea I've got.
    // Any suggestions are welcome on how to handle this better.

    return preg_replace('/\/\/+/u', '/', $request_uri);
}

/**
* Fetches user's post page preference
*
* Fetches the user's post page (POST_PAGE) setting from their user preferences.
* If no user preference is available it returns a default value or toolbar in
* plain text mode with emoticons, auto URL linking and signature display enabled.
*
* @return integer(32)
* @param void
*/

function bh_session_get_post_page_prefs()
{
    if (!$page_prefs = bh_session_get_value('POST_PAGE')) {
        $page_prefs = POST_TOOLBAR_DISPLAY | POST_EMOTICONS_DISPLAY | POST_TEXT_DEFAULT | POST_AUTO_LINKS | POST_SIGNATURE_DISPLAY;
    }

    return $page_prefs;
}

function bh_session_is_search_engine()
{
    if (!$db_bh_session_is_search_engine = db_connect()) return false;

    if (isset($_SERVER['HTTP_USER_AGENT']) && strlen(trim($_SERVER['HTTP_USER_AGENT'])) > 0) {

        $http_user_agent = db_escape_string($_SERVER['HTTP_USER_AGENT']);

        $sql = "SELECT SID FROM SEARCH_ENGINE_BOTS ";
        $sql.= "WHERE  '$http_user_agent' LIKE AGENT_MATCH ";

        if (!$result = db_query($sql, $db_bh_session_is_search_engine)) return false;

        if (db_num_rows($result) > 0) {

            list($search_engine_id) = db_fetch_array($result, DB_RESULT_NUM);
            return $search_engine_id;
        }
    }

    return false;
}

function bh_session_get_referer()
{
    if (($http_referer = bh_session_get_value('REFERER')) === false) {

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

?>