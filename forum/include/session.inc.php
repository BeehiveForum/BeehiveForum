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

/* $Id: session.inc.php,v 1.229 2006-07-14 21:46:13 decoyduck Exp $ */

/**
* session.inc.php - session functions
*
* Contains session related functions.
*/

/**
*
*/

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "banned.inc.php");
include_once(BH_INCLUDE_PATH. "db.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "ip.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "logon.inc.php");
include_once(BH_INCLUDE_PATH. "pm.inc.php");
include_once(BH_INCLUDE_PATH. "stats.inc.php");
include_once(BH_INCLUDE_PATH. "search.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

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
* @param string $use_sess_hash     - Specify MD5 hash to use for session rather than user's cookie.
*/

function bh_session_check($show_session_fail = true, $use_sess_hash = false)
{
    $db_bh_session_check = db_connect();

    if (!$ipaddress = get_ip_address()) $ipaddress = "";

    $forum_settings = forum_get_settings();

    // Current server time.

    $current_time = time();

    // Session cut off timestamp

    $active_sess_cutoff = intval(forum_get_setting('active_sess_cutoff', false, 900));

    // Check to see if we've been given a MD5 hash to use instead of the cookie.

    if (!is_bool($use_sess_hash) && is_md5($use_sess_hash)) {

        $user_hash = $use_sess_hash;
    
    }elseif (isset($_COOKIE['bh_sess_hash']) && is_md5($_COOKIE['bh_sess_hash'])) {

        $user_hash = $_COOKIE['bh_sess_hash'];
    }

    // Get the forum data

    if (!$table_data = get_table_prefix()) return false;

    $forum_fid = $table_data['FID'];

    // Check the current user's session data. This is the main session
    // data that Beehive relies on. If this data does not match what
    // we have stored in the database then the user gets logged out
    // automatically.

    if (isset($user_hash) && is_md5($user_hash)) {

        $sql = "SELECT SESSIONS.UID, UNIX_TIMESTAMP(SESSIONS.TIME) AS TIME, ";
        $sql.= "USER.LOGON, USER.NICKNAME, USER.EMAIL, USER.PASSWD, SESSIONS.FID, ";
        $sql.= "SESSIONS.IPADDRESS, SESSIONS.REFERER FROM SESSIONS SESSIONS ";
        $sql.= "LEFT JOIN USER ON (USER.UID = SESSIONS.UID) ";
        $sql.= "WHERE SESSIONS.HASH = '$user_hash'";

        $result = db_query($sql, $db_bh_session_check);

        if (db_num_rows($result) > 0) {

            // Fetch the session data from the database
            
            $user_sess = db_fetch_array($result, DB_RESULT_ASSOC);

            // If the session belongs to a guest pass control to bh_guest_session_init();

            if ($user_sess['UID'] == 0) {
                return bh_guest_session_init($user_hash);
            }

            // check to see if the user's credentials match the
            // ban data set up on this forum.

            ban_check($user_sess);

            // Add preference settings

            $user_sess = array_merge($user_sess, user_get_prefs($user_sess['UID']));

            // Add user perms

            $user_sess['PERMS'] = bh_session_get_perm_array($user_sess['UID']);

            // We need to check here to see if the user is
            // banned from this forum as the login check
            // may have failed because they weren't logging
            // in to a specific forum.

            if (bh_session_check_perm(USER_PERM_BANNED, 0)) {
            
                if (!strstr(php_sapi_name(), 'cgi')) {
                    header("HTTP/1.0 500 Internal Server Error");
                }

                echo "<h2>HTTP/1.0 500 Internal Server Error</h2>\n";
                exit;
            }

            // If the user isn't currently in the same forum
            // we should make it look like they've visited it.

            if ($user_sess['FID'] != $forum_fid) {

                $user_sess['FID'] = $forum_fid;
                
                $sql = "UPDATE SESSIONS SET FID = '$forum_fid' WHERE HASH = '$user_hash'";
                $result = db_query($sql, $db_bh_session_check);
                
                bh_update_visitor_log($user_sess['UID'], $forum_fid);
            }

            // Everything checks out OK. If the user's session is older
            // then $active_sess_cutoff we should update it.

            if (($current_time - $user_sess['TIME']) > $active_sess_cutoff) {

                $sql = "UPDATE SESSIONS SET TIME = NOW(), IPADDRESS = '$ipaddress' ";
                $sql.= "WHERE HASH = '$user_hash'";

                $result = db_query($sql, $db_bh_session_check);

                if (forum_get_setting('show_stats', 'Y')) {
                    update_stats();
                }

                bh_update_user_time($user_sess['UID']);

                // Perform system-wide PM Prune

                pm_system_prune_folders();

                // Delete expired sessions

                bh_remove_stale_sessions();
            }

            return $user_sess;

        }elseif ($show_session_fail) {

            bh_session_expired();
        }
    }

    return bh_guest_session_init();
}

function bh_session_expired()
{
    global $frame_top_target;
    
    if (defined("BEEHIVEMODE_LIGHT")) {
        header_redirect("./llogon.php?final_uri=". get_request_uri());
    }

    html_draw_top('logon.js');

    if (isset($_POST['user_logon']) && isset($_POST['user_password']) && isset($_POST['user_passhash'])) {

        if (perform_logon(false)) {

            $lang = load_language_file();
            $webtag = get_webtag($webtag_search);

            echo "<h1>{$lang['loggedinsuccessfully']}</h1>";

            $top_html = html_get_top_page();

            echo "<script language=\"Javascript\" type=\"text/javascript\">\n";
            echo "<!--\n\n";
            echo "if (top.document.body.rows) {\n\n";
            echo "    top.frames['ftop'].location.replace('$top_html');\n";
            echo "    top.frames['fnav'].location.reload();\n";
            echo "}\n\n";
            echo "-->\n";
            echo "</script>";

            echo "<div align=\"center\">\n";
            echo "<p><b>{$lang['presscontinuetoresend']}</b></p>\n";

            $request_uri = get_request_uri();

            if (stristr($request_uri, 'logon.php')) {

                if (isset($frame_top_target) && strlen($frame_top_target) > 0) {

                    echo "<form method=\"post\" action=\"$request_uri\" target=\"$frame_top_target\">\n";

                }else {

                    echo "<form method=\"post\" action=\"$request_uri\" target=\"_top\">\n";
                }

            }else {

                echo "<form method=\"post\" action=\"$request_uri\" target=\"_self\">\n";
            }

            echo form_input_hidden('webtag', $webtag);

            $ignore_keys = array('user_logon', 'user_password', 'user_passhash', 'remember_user', 'webtag');

            if (form_input_hidden_array($_POST, $post_vars, $ignore_keys)) {
                echo $post_vars;
            }

            echo form_submit(md5(uniqid(rand())), $lang['continue']), "&nbsp;";
            echo form_button(md5(uniqid(rand())), $lang['cancel'], "onclick=\"self.location.href='$request_uri'\""), "\n";
            echo "</form>\n";

            html_draw_bottom();
            exit;
        }
    }

    draw_logon_form(false);
    html_draw_bottom();
    exit;
}

function bh_guest_session_init($use_sess_hash = false)
{
    $db_bh_guest_session_init = db_connect();

    if (!$ipaddress = get_ip_address()) $ipaddress = "";

    $forum_settings = forum_get_settings();

    // Current server time.

    $current_time = time();

    // Session cut off timestamp

    $active_sess_cutoff = intval(forum_get_setting('active_sess_cutoff', false, 900));

    // Check to see if we've been given a MD5 hash to use instead of the cookie.

    if (!is_bool($use_sess_hash) && is_md5($use_sess_hash)) {

        $user_hash = $use_sess_hash;
    
    }else {

        $user_hash = md5($ipaddress);
    }

    // HTTP referrer

    if (!$http_referer = bh_session_get_value('REFERER')) {
        if (isset($_SERVER['HTTP_REFERER']) && strlen(trim($_SERVER['HTTP_REFERER'])) > 0) {
            $http_referer = addslashes(trim($_SERVER['HTTP_REFERER']));
        }else {
            $http_referer = "";
        }
    }
    
    if (user_guest_enabled()) {

        // Guest user sessions are handled a bit differently.
        // Rather than the cookie which holds their HASH we
        // keep track of guest sessions based on the user's IP
        // address. Of course this means that the guest counter
        // will be out if there is more than one guest coming
        // from a single IP address.

        if ($table_data = get_table_prefix()) {
            $forum_fid = $table_data['FID'];
        }else {
            $forum_fid = 0;
        }

        $sql = "SELECT UID, UNIX_TIMESTAMP(SESSIONS.TIME) AS TIME, 'GUEST' AS LOGON, ";
        $sql.= "MD5('GUEST') AS PASSWD, FID, IPADDRESS, REFERER FROM SESSIONS ";
        $sql.= "WHERE HASH = '$user_hash' ";

        $result = db_query($sql, $db_bh_guest_session_init);

        if (db_num_rows($result) > 0) {

            $user_sess = db_fetch_array($result);

            // Add user perms

            $user_sess['PERMS'] = bh_session_get_perm_array($user_sess['UID']);

            // If the user isn't currently in the same forum
            // we should make it look like they've visited it.

            if ($user_sess['FID'] != $forum_fid) {

                $user_sess['FID'] = $forum_fid;
                
                $sql = "UPDATE SESSIONS SET FID = '$forum_fid' WHERE HASH = '$user_hash'";
                $result = db_query($sql, $db_bh_session_check);
                
                bh_update_visitor_log($user_sess['UID'], $forum_fid);
            }

            // Everything checks out OK. If the user's session is older
            // then $active_sess_cutoff we should update it.

            if (($current_time - $user_sess['TIME']) > $active_sess_cutoff) {

                $sql = "UPDATE SESSIONS SET TIME = NOW(), ";
                $sql.= "FID = '$forum_fid', IPADDRESS = '$ipaddress' ";
                $sql.= "WHERE HASH = '$user_hash'";

                $result = db_query($sql, $db_bh_guest_session_init);

                bh_remove_stale_sessions();
            }

        }else {

            $sql = "INSERT INTO SESSIONS (HASH, UID, FID, IPADDRESS, TIME, REFERER) ";
            $sql.= "VALUES ('$user_hash', 0, $forum_fid, '$ipaddress', NOW(), '$http_referer')";

            $result = db_query($sql, $db_bh_guest_session_init);

            bh_update_visitor_log(0);

            $user_sess = array('UID'       => 0,
                               'TIME'      => mktime(),
                               'LOGON'     => 'GUEST',
                               'PASSWD'    => md5('GUEST'),
                               'FID'       => $forum_fid,
                               'IPADDRESS' => $ipaddress,
                               'REFERER'   => $http_referer,
                               'PERMS'     => bh_session_get_perm_array(0));
        }

        // check to see if the user's credentials match the
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
* @return mixed
* @param string $session_key - Named key of the session variable to fetch.
*/

function bh_session_active()
{
    global $user_sess;

    $guest_auto_logon = forum_get_setting('guest_auto_logon', 'Y');

    if (isset($_COOKIE['bh_logon'])) return false;
    if (isset($user_sess['UID'])) return true;
    if (user_cookies_set()) return false;
    if (user_guest_enabled() && $guest_auto_logon) return true;

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
    global $user_sess;

    if (!is_array($user_sess)) return false;
    if (isset($user_sess[$session_key])) return $user_sess[$session_key];
    if (strtoupper($session_key) == 'UID') return 0;

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
    if (!$table_data = get_table_prefix()) return false;   

    $forum_fid = $table_data['FID'];
    
    $sess_rem_prob = intval(forum_get_setting('sess_rem_prob', false, 1));

    if ((time() % (100 / $sess_rem_prob)) == 0) {

        $db_bh_remove_stale_sessions = db_connect();

        if ($session_cutoff = forum_get_setting('session_cutoff', false, 86400)) {

            $session_stamp = time() - $session_cutoff;

            $sql = "SELECT UID FROM SESSIONS WHERE TIME < FROM_UNIXTIME($session_stamp)";
            $result = db_query($sql, $db_bh_remove_stale_sessions);

            while ($session_data = db_fetch_array($result)) {
                bh_update_user_time($session_data['UID']);
            }            
            
            $sql = "DELETE FROM SESSIONS WHERE ";
            $sql.= "TIME < FROM_UNIXTIME($session_stamp)";

            $result = db_query($sql, $db_bh_remove_stale_sessions);
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

function bh_update_visitor_log($uid, $forum_fid = false)
{
    if (!is_numeric($uid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($forum_fid)) $forum_fid = $table_data['FID'];

    $db_bh_update_visitor_log = db_connect();

    if ($uid > 0) {

        $user_prefs = user_get_prefs($uid);

        $sql = "SELECT LAST_LOGON FROM VISITOR_LOG WHERE UID = '$uid'";
        $sql.= "AND FORUM = '$forum_fid'";

        $result = db_query($sql, $db_bh_update_visitor_log);

        if (db_num_rows($result) > 0) {

            $sql = "UPDATE VISITOR_LOG SET LAST_LOGON = NOW() ";
            $sql.= "WHERE UID = '$uid' AND FORUM = '$forum_fid'";

        }else {

            $sql = "INSERT INTO VISITOR_LOG (FORUM, UID, LAST_LOGON) ";
            $sql.= "VALUES ('$forum_fid', '$uid', NOW())";
        }

        if ($result = db_query($sql, $db_bh_update_visitor_log)) return true;

    }else {

        if (($search_id = bh_session_is_search_engine()) !== false) {

            $sql = "INSERT INTO VISITOR_LOG (FORUM, UID, LAST_LOGON, SID) ";
            $sql.= "VALUES ('$forum_fid', 0, NOW(), '$sid')";

        }else {

            $sql = "INSERT INTO VISITOR_LOG (FORUM, UID, LAST_LOGON) ";
            $sql.= "VALUES ('$forum_fid', 0, NOW())";
        }

        if ($result = db_query($sql, $db_bh_update_visitor_log)) return true;
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

    $db_bh_update_user_time = db_connect();
        
    $sql = "SELECT UNIX_TIMESTAMP(NOW()) AS TIME, UNIX_TIMESTAMP(LAST_LOGON) AS LAST_LOGON ";
    $sql.= "FROM VISITOR_LOG WHERE UID = '$uid' AND FORUM = '$forum_fid'";

    $result = db_query($sql, $db_bh_update_user_time);

    if (db_num_rows($result) > 0) {

        if ($user_track = db_fetch_array($result)) {

            if (isset($user_track['LAST_LOGON']) && !is_null($user_track['LAST_LOGON'])) {

                $session_length = 0;

                if ($user_track['TIME'] > $user_track['LAST_LOGON']) {
                    $session_length = $user_track['TIME'] - $user_track['LAST_LOGON'];
                }

                $sql = "SELECT UNIX_TIMESTAMP(USER_TIME_TOTAL) AS USER_TIME_TOTAL, ";
                $sql.= "UNIX_TIMESTAMP(USER_TIME_BEST) AS USER_TIME_BEST FROM ";
                $sql.= "{$table_data['PREFIX']}USER_TRACK ";
                $sql.= "WHERE UID = '$uid'";

                $result = db_query($sql, $db_bh_update_user_time);

                if (db_num_rows($result) > 0) {

                    $user_time = db_fetch_array($result);

                    $update_columns_array = array();

                    if (!isset($user_time['USER_TIME_BEST']) || is_null($user_time['USER_TIME_BEST'])) {
                        $user_time['USER_TIME'] = 0;
                    }

                    if (!isset($user_time['USER_TIME_TOTAL']) || is_null($user_time['USER_TIME_TOTAL'])) {
                        $user_time['USER_TIME_TOTAL'] = 0;
                    }

                    if ($session_length > $user_time['USER_TIME_BEST']) {
                        $update_columns_array[] = "USER_TIME_BEST = FROM_UNIXTIME('$session_length')";
                    }

                    $session_length += $user_time['USER_TIME_TOTAL'];
                    $update_columns_array[] = "USER_TIME_TOTAL = FROM_UNIXTIME('$session_length')";

                    $update_columns = implode(", ", $update_columns_array);

                    $sql = "UPDATE {$table_data['PREFIX']}USER_TRACK ";
                    $sql.= "SET $update_columns WHERE UID = '$uid'";

                    $result = db_query($sql, $db_bh_update_user_time);

                }else {

                    $sql = "INSERT INTO {$table_data['PREFIX']}USER_TRACK ";
                    $sql.= "(UID, USER_TIME_BEST, USER_TIME_TOTAL) ";
                    $sql.= "VALUES ('$uid', FROM_UNIXTIME('$session_length'), ";
                    $sql.= "FROM_UNIXTIME('$session_length'))";

                    $result = db_query($sql, $db_bh_update_user_time);
                }
            }
        }
    }
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
    $db_bh_session_init = db_connect();

    if (!is_numeric($uid)) return false;

    if (!$ipaddress = get_ip_address()) $ipaddress = "";

    if ($table_data = get_table_prefix()) {
        $forum_fid = $table_data['FID'];
    }else {
        $forum_fid = 0;
    }

    if (!$http_referer = bh_session_get_value('REFERER')) {
        if (isset($_SERVER['HTTP_REFERER']) && strlen(trim($_SERVER['HTTP_REFERER'])) > 0) {
            $http_referer = addslashes(trim($_SERVER['HTTP_REFERER']));
        }else {
            $http_referer = "";
        }
    }

    $sql = "SELECT HASH FROM SESSIONS WHERE UID = $uid ";
    $sql.= "AND IPADDRESS = '$ipaddress'";

    $result = db_query($sql, $db_bh_session_init);

    if (db_num_rows($result) > 0) {

        list($user_hash) = db_fetch_array($result, DB_RESULT_NUM);

    }else {

        $user_hash = md5(uniqid(rand()));

        $sql = "INSERT INTO SESSIONS (HASH, UID, FID, IPADDRESS, TIME, REFERER) ";
        $sql.= "VALUES ('$user_hash', '$uid', '$forum_fid', ";
        $sql.= "'$ipaddress', NOW(), '$http_referer')";

        $result = db_query($sql, $db_bh_session_init);
    }

    if ($update_visitor_log === true) bh_update_visitor_log($uid);
    if ($skip_cookie === false) bh_setcookie('bh_sess_hash', $user_hash);

    return $user_hash;
}

/**
* Ends current user session.
*
* Ends session for current logged in user by retrieving their cookie hash
* and destroying relevant data in the SESSION table.
*
* @return void
* @param void
*/

function bh_session_end()
{
    $db_bh_session_end = db_connect();

    if (!$table_data = get_table_prefix()) return false;   

    if (($uid = bh_session_get_value('UID')) === false) return false;

    if (!$ipaddress = get_ip_address()) $ipaddress = "";

    // Session cookie

    if (isset($_COOKIE['bh_sess_hash']) && is_md5($_COOKIE['bh_sess_hash'])) {
        $user_hash = $_COOKIE['bh_sess_hash'];
    }elseif ($uid > 0) {
        $user_hash = md5($ipaddress);
    }

    if (isset($user_hash)) {

        // If the user isn't a guest we should update how long
        // they have been actively logged in.
        
        if ($uid > 0) bh_update_user_time($uid);

        // Remove the user session.

        $sql = "DELETE FROM SESSIONS WHERE HASH = '$user_hash'";
        $result = db_query($sql, $db_bh_session_end);
    }

    // Unset the cookies used by Beehive.

    bh_setcookie("bh_sess_hash", "", time() - YEAR_IN_SECONDS);
    bh_setcookie("bh_thread_mode", "", time() - YEAR_IN_SECONDS);
    bh_setcookie("bh_logon", "1", time() - YEAR_IN_SECONDS);
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
    if (!is_numeric($uid)) return false;

    $user_perm_array = array();

    $db_bh_session_get_perm_array = db_connect();

    if (!$table_data = get_table_prefix()) return false;   

    $sql = "SELECT GP.GID, GP.FORUM, GP.FID, BIT_OR(GP.PERM) AS PERM ";
    $sql.= "FROM GROUP_PERMS GP LEFT JOIN GROUP_USERS GU ON (GU.GID = GP.GID) ";
    $sql.= "WHERE GU.UID = '$uid' GROUP BY GP.FORUM, GP.FID";

    $result = db_query($sql, $db_bh_session_get_perm_array);

    while ($row = db_fetch_array($result)) {
        $user_perm_array[$row['FORUM']][$uid][$row['FID']] = $row['PERM'];
    }

    $sql = "SELECT FORUM, FID, BIT_OR(PERM) AS PERM ";
    $sql.= "FROM GROUP_PERMS WHERE GID = 0 ";
    $sql.= "GROUP BY FORUM, FID";

    $result = db_query($sql, $db_bh_session_get_perm_array);

    while ($row = db_fetch_array($result)) {

        $user_perm_array[$row['FORUM']][0][$row['FID']] = $row['PERM'];
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
    global $user_sess;

    if (!is_array($user_sess)) return false;
    if (!is_numeric($folder_fid)) return false;

    if ($forum_fid === false) {

        if (!$table_data = get_table_prefix()) return false;
        $forum_fid = $table_data['FID'];
    }

    if (($uid = bh_session_get_value('UID')) === false) return false;

    if (isset($user_sess['PERMS'][$forum_fid][$uid][$folder_fid])) {
        return (($user_sess['PERMS'][$forum_fid][$uid][$folder_fid] & $perm) == $perm);
    }

    if (isset($user_sess['PERMS'][$forum_fid][0][$folder_fid])) {
        return (($user_sess['PERMS'][$forum_fid][0][$folder_fid] & $perm) == $perm);
    }

    if (isset($user_sess['PERMS'][0][$uid][$folder_fid])) {
        return (($user_sess['PERMS'][0][$uid][$folder_fid] & $perm) == $perm);
    }

    return false;
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

function bh_session_get_perm($folder_fid, $forum_fid = false)
{
    global $user_sess;

    if (!is_array($user_sess)) return false;
    if (!is_numeric($folder_fid)) return false;

    if ($forum_fid === false) {

        if (!$table_data = get_table_prefix()) return false;
        $forum_fid = $table_data['FID'];
    }

    if (($uid = bh_session_get_value('UID')) === false) return false;

    if (isset($user_sess['PERMS'][$forum_fid][$uid][$folder_fid])) {
        return $user_sess['PERMS'][$forum_fid][$uid][$folder_fid];
    }

    if (isset($user_sess['PERMS'][$forum_fid][0][$folder_fid])) {
        return $user_sess['PERMS'][$forum_fid][0][$folder_fid];
    }

    if (isset($user_sess['PERMS'][0][$uid][$folder_fid])) {
        return $user_sess['PERMS'][0][$uid][$folder_fid];
    }

    return false;
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
    global $user_sess;

    if (!is_numeric($perm)) return false;

    if ($forum_fid === false) {

        if (!$table_data = get_table_prefix()) return false;
        $forum_fid = $table_data['FID'];
    }

    $folder_fid_array = array();

    if (($uid = bh_session_get_value('UID')) === false) return false;

    // Test each folder against the provided perm at both the folder
    // and user levels.

    if (isset($user_sess['PERMS'][$forum_fid][0]) && is_array($user_sess['PERMS'][$forum_fid][0])) {

        foreach($user_sess['PERMS'][$forum_fid][0] as $folder_fid => $folder_perm) {

            if (isset($user_sess['PERMS'][$forum_fid][$uid][$folder_fid])) {
                
                if (($user_sess['PERMS'][$forum_fid][$uid][$folder_fid] & $perm) == $perm) {

                    $folder_fid_array[$folder_fid] = $folder_fid;
                }

            }else {

                if (($folder_perm & $perm) == $perm) $folder_fid_array[$folder_fid] = $folder_fid;
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
* @param string $result_var - By reference result variable which contains the returned string.
*/

function parse_array($array, $sep, &$result_var)
{
    if (!is_array($array)) return false;

    if (!is_string($result_var)) $result_var = "";
    if (!is_string($sep) || strlen($sep) == 0) $sep = "&";

    $preg_sep = preg_quote($sep, "/");

    foreach ($array as $key => $value) {

        if (is_array($value)) {

            parse_array($value, $sep, $result_var);

        }else {

            $value = rawurlencode($value);

            if ($key == 'webtag') {

                if (preg_match("/^[A-Z0-9_]+$/", $value) > 0) {

                    $result_var.= "webtag=$value$sep";
                }

            }else {

                $result_var.= "$key=$value$sep";
            }
        }
    }

    $result_var = preg_replace("/$preg_sep$/", "", $result_var);

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

function get_request_uri($encoded_uri_query = true)
{
    if (!is_bool($encoded_uri_query)) $encoded_uri_query = true;

    $request_uri = "{$_SERVER['PHP_SELF']}?";

    if ($encoded_uri_query) {
        parse_array($_GET, "&amp;", $request_uri);
    }else {
        parse_array($_GET, "&", $request_uri);
    }

    // Fix the slashes for forum running from sub-domain.
    // Rather dirty hack this, but it's the only idea I've got.
    // Any suggestions are welcome on how to handle this better.

    return preg_replace("/\/\/+/", "/", $request_uri);
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
    global $user_sess;

    if (!$page_prefs = bh_session_get_value('POST_PAGE')) {
        $page_prefs = POST_TOOLBAR_DISPLAY | POST_EMOTICONS_DISPLAY | POST_TEXT_DEFAULT | POST_AUTO_LINKS | POST_SIGNATURE_DISPLAY;
    }

    return $page_prefs;
}

function bh_session_is_search_engine()
{
    $db_bh_session_is_search_engine = db_connect();
        
    if (!$table_data = get_table_prefix()) return false;

    if (isset($_SERVER['HTTP_USER_AGENT']) && strlen(trim($_SERVER['HTTP_USER_AGENT'])) > 0) {

        $http_user_agent = addslashes($_SERVER['HTTP_USER_AGENT']);
    
        $sql = "SELECT SID FROM SEARCH_ENGINE_BOTS ";
        $sql.= "WHERE  '$http_user_agent' LIKE AGENT_MATCH ";

        $result = db_query($sql, $db_bh_session_is_search_engine);

        if (db_num_rows($result) > 0) {

            list($search_engine_id) = db_fetch_array($result, DB_RESULT_NUM);
            return $search_engine_id;
        }
    }

    return false;
}

?>