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

/* $Id: session.inc.php,v 1.308 2007-06-18 13:37:05 decoyduck Exp $ */

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
* @param string $use_sess_hash     - Specify MD5 hash to use for session rather than user's cookie.
*/

function bh_session_check($show_session_fail = true, $use_sess_hash = false)
{
    $db_bh_session_check = db_connect();

    if (!$ipaddress = get_ip_address()) $ipaddress = "";

    $forum_settings = forum_get_settings();

    // Check to see if we've been given a MD5 hash to use instead of the cookie.

    if (!is_bool($use_sess_hash) && is_md5($use_sess_hash)) {

        $user_hash = $use_sess_hash;
    
    }elseif (isset($_COOKIE['bh_sess_hash']) && is_md5($_COOKIE['bh_sess_hash'])) {

        $user_hash = $_COOKIE['bh_sess_hash'];
    }

    // Check for a webtag and get the forum FID.

    if ($table_data = get_table_prefix()) {
        $forum_fid = $table_data['FID'];
    }else {
        $forum_fid = 0;
    }

    // Check the current user's session data. This is the main session
    // data that Beehive relies on. If this data does not match what
    // we have stored in the database then the user gets logged out
    // automatically.

    if (isset($user_hash) && is_md5($user_hash)) {

        $sql = "SELECT SESSIONS.HASH, SESSIONS.UID, SESSIONS.IPADDRESS, ";
        $sql.= "UNIX_TIMESTAMP(SESSIONS.TIME) AS TIME, SESSIONS.FID, ";
        $sql.= "SESSIONS.REFERER, USER.LOGON, USER.NICKNAME, USER.EMAIL, ";
        $sql.= "USER.PASSWD FROM SESSIONS SESSIONS ";
        $sql.= "LEFT JOIN USER ON (USER.UID = SESSIONS.UID) ";
        $sql.= "WHERE SESSIONS.HASH = '$user_hash'";

        if (!$result = db_query($sql, $db_bh_session_check)) return false;

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

            // If the user isn't currently in the same forum we
            // need to update the session so they appear on the
            // active user log and visitor log otherwise we
            // simply update the user's time and IP address.

            if (isset($user_sess['FID']) && is_numeric($user_sess['FID']) && $user_sess['FID'] != $forum_fid) {
                
                $sql = "UPDATE SESSIONS SET FID = '$forum_fid', TIME = NOW(), ";
                $sql.= "IPADDRESS = '$ipaddress' WHERE HASH = '$user_hash'";

                if (!$result = db_query($sql, $db_bh_session_check)) return false;
                
                bh_update_visitor_log($user_sess['UID'], $forum_fid);

                forum_update_last_visit($user_sess['UID']);

            }else {

                $sql = "UPDATE SESSIONS SET TIME = NOW(), IPADDRESS = '$ipaddress' ";
                $sql.= "WHERE HASH = '$user_hash'";

                if (!$result = db_query($sql, $db_bh_session_check)) return false;
            }

            // A unique MD5 has for some purposes (word filter, etc)
            
            $user_sess['RAND_HASH'] = md5(uniqid(rand()));

            // Forum self-preservation functions. Each page load
            // we only do one of these. The functions themselves
            // return false if the random probability meant they
            // ended up doing nothing so we can then try the next
            // one and so forth.

            if (!update_stats()) {

                if (!bh_update_user_time($user_sess['UID'])) {

                    if (!pm_system_prune_folders()) {

                        if (!bh_remove_stale_sessions()) {

                            if (!thread_auto_prune_unread_data()) {

                                captcha_clean_up();
                            }
                        }
                    }
                }
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
    $webtag = get_webtag($webtag_search);

    $lang = load_language_file();
    
    if (defined("BEEHIVEMODE_LIGHT")) {
        header_redirect("./llogon.php?webtag=$webtag&final_uri=". get_request_uri());
    }

    if (isset($_POST['logon']) || isset($_POST['guest_logon'])) {

        if (logon_perform(false)) {

            logon_unset_post_data();
                        
            $request_uri = get_request_uri(true, false);

            if (isset($_POST) && is_array($_POST) && sizeof($_POST) > 0) {
            
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

                echo "<div align=\"center\">\n";
                echo "<h2>{$lang['presscontinuetoresend']}</h2>\n";

                if (stristr($request_uri, 'logon.php')) {

                    echo "<form method=\"post\" action=\"$request_uri\" target=\"", html_get_top_frame_name(), "\">\n";

                }else {

                    echo "<form method=\"post\" action=\"$request_uri\" target=\"_self\">\n";
                }

                echo form_input_hidden('webtag', _htmlentities($webtag));

                $ignore_keys = array('user_logon', 'user_password', 'user_passhash', 'remember_user', 'webtag');
                
                echo form_input_hidden_array(_stripslashes($_POST), $ignore_keys);

                echo form_submit('continue', $lang['continue']), "&nbsp;";
                echo form_button('cancel', $lang['cancel'], "onclick=\"self.location.href='$request_uri'\""), "\n";
                echo "</form>\n";
                echo "</div>\n";

                html_draw_bottom();
                exit;

            }else {

                $sep = strstr($request_uri, '?') ? "&" : "?";
                $request_uri = "{$request_uri}{$sep}reload_frames=true";

                header_redirect($request_uri, $lang['loggedinsuccessfully']);
                exit;
            }

        }else {

            bh_setcookie("bh_logon_failed", "1");
        }
    }

    html_draw_top('logon.js');

    echo "<div align=\"center\">\n";
    echo "  <h2>{$lang['yoursessionhasexpired']}</h2>\n";

    logon_draw_form(false);

    echo "</div>\n";

    html_draw_bottom();
    exit;
}

function bh_guest_session_init($use_sess_hash = false, $update_visitor_log = true)
{
    $db_bh_guest_session_init = db_connect();

    if (!$ipaddress = get_ip_address()) $ipaddress = "";

    $forum_settings = forum_get_settings();

    // Check to see if we've been given a MD5 hash to use instead of the cookie.

    if (!is_bool($use_sess_hash) && is_md5($use_sess_hash)) {

        $user_hash = $use_sess_hash;
    
    }else {

        $user_hash = md5($ipaddress);
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

        $sql = "SELECT HASH, UID, UNIX_TIMESTAMP(SESSIONS.TIME) AS TIME, ";
        $sql.= "'GUEST' AS LOGON, MD5('GUEST') AS PASSWD, FID, IPADDRESS, ";
        $sql.= "REFERER FROM SESSIONS WHERE HASH = '$user_hash' ";

        if (!$result = db_query($sql, $db_bh_guest_session_init)) return false;

        if (db_num_rows($result) > 0) {

            $user_sess = db_fetch_array($result);

            // Add user perms

            $user_sess['PERMS'] = bh_session_get_perm_array(0);

            // A unique MD5 has for some purposes (word filter, etc)
            
            $user_sess['RAND_HASH'] = md5(uniqid(rand()));

            // If the user isn't currently in the same forum we
            // need to update the session so they appear on the
            // active user log and visitor log otherwise we
            // simply update the user's time and IP address.

            if ($user_sess['FID'] != $forum_fid) {
                
                $ipaddress = db_escape_string($ipaddress);
                
                $sql = "UPDATE SESSIONS SET FID = '$forum_fid', TIME = NOW(), ";
                $sql.= "IPADDRESS = '$ipaddress' WHERE HASH = '$user_hash'";

                if (!$result = db_query($sql, $db_bh_guest_session_init)) return false;
                
                bh_update_visitor_log(0, $forum_fid, true);

            }else {

                $ipaddress = db_escape_string($ipaddress);

                $sql = "UPDATE SESSIONS SET TIME = NOW(), IPADDRESS = '$ipaddress' ";
                $sql.= "WHERE HASH = '$user_hash'";

                if (!$result = db_query($sql, $db_bh_guest_session_init)) return false;
            }

        }else {

            // HTTP referer
        
            $http_referer = bh_session_get_referer();

            // Session array of default values.

            $user_sess = array('UID'       => 0,
                               'TIME'      => mktime(),
                               'LOGON'     => 'GUEST',
                               'PASSWD'    => md5('GUEST'),
                               'FID'       => $forum_fid,
                               'IPADDRESS' => $ipaddress,
                               'REFERER'   => $http_referer,
                               'PERMS'     => bh_session_get_perm_array(0),
                               'RAND_HASH' => md5(uniqid(rand())));

            $http_referer = db_escape_string($http_referer);

            // Start a session for the new guest user

            $sql = "INSERT INTO SESSIONS (HASH, UID, FID, IPADDRESS, TIME, REFERER) ";
            $sql.= "VALUES ('$user_hash', 0, $forum_fid, '$ipaddress', NOW(), '$http_referer')";

            if (!$result = db_query($sql, $db_bh_guest_session_init)) return false;

            // Update visitor log.

            if ($update_visitor_log === true) {
                bh_update_visitor_log(0);
            }
        }

        // check to see if the user's credentials match the
        // ban data set up on this forum.

        ban_check($user_sess, true);

        // Forum self-preservation functions. Each page load
        // we only do one of these. The functions themselves
        // return false if the random probability meant they
        // ended up doing nothing so we can then try the next
        // one and so forth.

        if (!update_stats()) {

            if (!pm_system_prune_folders()) {

                if (!bh_remove_stale_sessions()) {

                    if (!visitor_log_clean_up()) {
                    
                        if (!captcha_clean_up()) {
                    
                            thread_auto_prune_unread_data();
                        }
                    }
                }
            }
        }

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
    if (isset($_COOKIE['bh_logon'])) return false;
    if (user_cookies_set() && user_is_guest()) return false;
    if ((user_guest_enabled() && user_is_guest()) || !user_is_guest()) return true;

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
    $sess_rem_prob = intval(forum_get_setting('forum_self_clean_prob', false, 10000));

    if ($sess_rem_prob < 1) $sess_rem_prob = 1;
    if ($sess_rem_prob > 10000) $sess_rem_prob = 10000;

    if (($mt_result = mt_rand(1, $sess_rem_prob)) == 1) {

        $db_bh_remove_stale_sessions = db_connect();

        if ($session_cutoff = forum_get_setting('session_cutoff', false, 86400)) {

            $sql = "DELETE FROM SESSIONS WHERE UID = 0 AND ";
            $sql.= "TIME < FROM_UNIXTIME(UNIX_TIMESTAMP(NOW()) - $session_cutoff) ";

            if (!$result = db_query($sql, $db_bh_remove_stale_sessions)) return false;

            $expired_sessions_array = array();

            $sql = "SELECT HASH, UID FROM SESSIONS WHERE ";
            $sql.= "TIME < FROM_UNIXTIME(UNIX_TIMESTAMP(NOW()) - $session_cutoff) ";
            $sql.= "AND UID > 0 LIMIT 0, 5";

            if (!$result = db_query($sql, $db_bh_remove_stale_sessions)) return false;

            while ($session_data = db_fetch_array($result)) {
                
                bh_update_user_time($session_data['UID']);
                $expired_sessions_array[] = $session_data['HASH'];
            }            

            if (sizeof($expired_sessions_array) > 0) {
            
                $expired_sessions = implode("', '", $expired_sessions_array);
                
                $sql = "DELETE FROM SESSIONS WHERE HASH IN ('$expired_sessions') ";
                $sql.= "AND TIME < FROM_UNIXTIME(UNIX_TIMESTAMP(NOW()) - $session_cutoff) ";

                if (!$result = db_query($sql, $db_bh_remove_stale_sessions)) return false;

                return true;
            }
        }
    }

    return false;
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

function bh_update_visitor_log($uid, $forum_fid = false, $force_update = false)
{
    if (!is_numeric($uid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    if (!is_numeric($forum_fid)) $forum_fid = $table_data['FID'];
    if (!is_bool($force_update)) $force_update = false;

    if (!$ipaddress = get_ip_address()) $ipaddress = "";

    $db_bh_update_visitor_log = db_connect();

    if ($uid > 0) {

        $http_referer = db_escape_string(bh_session_get_referer());
        $ipaddress = db_escape_string($ipaddress);

        $sql = "SELECT LAST_LOGON FROM VISITOR_LOG WHERE UID = '$uid'";
        $sql.= "AND FORUM = '$forum_fid'";

        if (!$result = db_query($sql, $db_bh_update_visitor_log)) return false;

        if (db_num_rows($result) > 0) {

            $sql = "UPDATE VISITOR_LOG SET LAST_LOGON = NOW(), ";
            $sql.= "IPADDRESS = '$ipaddress' WHERE UID = '$uid' ";
            $sql.= "AND FORUM = '$forum_fid'";

        }else {

            $sql = "INSERT INTO VISITOR_LOG (FORUM, UID, LAST_LOGON, IPADDRESS, REFERER) ";
            $sql.= "VALUES ('$forum_fid', '$uid', NOW(), '$ipaddress', '$http_referer')";
        }

        if ($result = db_query($sql, $db_bh_update_visitor_log)) return true;

    }else {

        $http_referer = db_escape_string(bh_session_get_referer());
        $ipaddress = db_escape_string($ipaddress);

        $session_cutoff = forum_get_setting('session_cutoff', false, 86400);

        $sql = "SELECT LAST_LOGON FROM VISITOR_LOG WHERE UID = '0' ";
        $sql.= "AND IPADDRESS = '$ipaddress' AND FORUM = '$forum_fid' ";
        $sql.= "AND LAST_LOGON > FROM_UNIXTIME(UNIX_TIMESTAMP(NOW()) - $session_cutoff)";

        if (!$result = db_query($sql, $db_bh_update_visitor_log)) return false;

        if ((db_num_rows($result) == 0) || $force_update === true) {

            if (($search_id = bh_session_is_search_engine()) !== false) {

                $sql = "SELECT LAST_LOGON FROM VISITOR_LOG WHERE SID = '$search_id'";
                $sql.= "AND FORUM = '$forum_fid'";

                if (!$result = db_query($sql, $db_bh_update_visitor_log)) return false;

                if (db_num_rows($result) > 0) {

                    $sql = "UPDATE VISITOR_LOG SET LAST_LOGON = NOW(), ";
                    $sql.= "IPADDRESS = '$ipaddress' WHERE SID = '$search_id' ";
                    $sql.= "AND FORUM = '$forum_fid'";

                }else {

                    $sql = "INSERT INTO VISITOR_LOG (FORUM, UID, LAST_LOGON, IPADDRESS, REFERER, SID) ";
                    $sql.= "VALUES ('$forum_fid', 0, NOW(), '$ipaddress', '$http_referer', '$search_id')";
                }

                if ($result = db_query($sql, $db_bh_update_visitor_log)) return true;

            }else {

                $sql = "INSERT INTO VISITOR_LOG (FORUM, UID, LAST_LOGON, IPADDRESS, REFERER) ";
                $sql.= "VALUES ('$forum_fid', 0, NOW(), '$ipaddress', '$http_referer')";
            }

            if ($result = db_query($sql, $db_bh_update_visitor_log)) return true;
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

    $db_bh_update_user_time = db_connect();

    $active_sess_cutoff = intval(forum_get_setting('active_sess_cutoff', false, 900));
        
    $sql = "SELECT UNIX_TIMESTAMP(VISITOR_LOG.LAST_LOGON) AS LAST_LOGON, ";
    $sql.= "UNIX_TIMESTAMP(USER_TRACK.USER_TIME_BEST) AS USER_TIME_BEST, ";
    $sql.= "UNIX_TIMESTAMP(USER_TRACK.USER_TIME_TOTAL) AS USER_TIME_TOTAL, ";
    $sql.= "UNIX_TIMESTAMP(USER_TRACK.USER_TIME_UPDATED) AS USER_TIME_UPDATED, ";
    $sql.= "UNIX_TIMESTAMP(NOW()) AS TIME FROM VISITOR_LOG VISITOR_LOG ";
    $sql.= "LEFT JOIN  {$table_data['PREFIX']}USER_TRACK USER_TRACK ";
    $sql.= "ON (USER_TRACK.UID = VISITOR_LOG.UID) ";
    $sql.= "WHERE VISITOR_LOG.FORUM = '$forum_fid' ";
    $sql.= "AND VISITOR_LOG.UID = '$uid'";

    if (!$result = db_query($sql, $db_bh_update_user_time)) return false;

    if (db_num_rows($result) > 0) {

        // Fetch the existing data from the database.
        
        $user_track = db_fetch_array($result);

        // Initialise our update array for updating the database.

        $update_columns_array = array();

        // If the user doesn't have a LAST_LOGON  set we need to
        // set it to something otherwise things mess up.

        if (!isset($user_track['LAST_LOGON']) || is_null($user_track['LAST_LOGON'])) {
            $user_track['LAST_LOGON'] = $user_track['TIME'];
        }

        // Ensure that the LAST_LOGON is never in the future.

        if ($user_track['LAST_LOGON'] > $user_track['TIME']) {
            $user_track['LAST_LOGON'] = $user_track['TIME'];
        }

        // If the user doesn't have a USER_TIME_BEST or USER_TIME_TOTAL we need to
        // set them to 0 for the rest of the function to work as expected.

        if (!isset($user_track['USER_TIME_BEST']) || is_null($user_track['USER_TIME_BEST'])) {
            $user_track['USER_TIME_BEST'] = 0;
        }

        if (!isset($user_track['USER_TIME_TOTAL']) || is_null($user_track['USER_TIME_TOTAL'])) {
            $user_track['USER_TIME_TOTAL'] = 0;
        }

        // Default values for a few variables just incase.

        $session_length = 0;
        $session_difference = 0;
        $session_total_time = 0;

        // If the current MySQL server time is newer than the last logon
        // we should calculate the session length.

        if ($user_track['TIME'] > $user_track['LAST_LOGON']) {
            $session_length = $user_track['TIME'] - $user_track['LAST_LOGON'];
        }

        // If the session length calculated above is higher than USER_TIME_BEST
        // we need to update the database to reflect that.

        if ($session_length > $user_track['USER_TIME_BEST']) {
            $update_columns_array[] = "USER_TIME_BEST = FROM_UNIXTIME('$session_length')";
        }

        // If the user doesn't have a USER_TIME_UPDATED set then we need
        // to calculate the difference between TIME and LAST_LOGON and
        // set USER_TIME_UPDATED to some value.
        // 
        // If the user's LAST_LOGON is newer than USER_TIME_UPDATED then
        // they have just logged on and we need to calculate the difference
        // between TIME and LAST_LOGON.
        //
        // If the user's USER_TIME_UPDATED is newer than LAST_LOGON then
        // this is not the first time we're updating this session and we
        // should instead calculate the difference between
        // TIME and USER_TIME_UPDATED.


        if (!isset($user_track['USER_TIME_UPDATED']) || is_null($user_track['USER_TIME_UPDATED'])) {

            $user_track['USER_TIME_UPDATED'] = 0;

            $session_total_time = ($user_track['TIME'] - $user_track['LAST_LOGON']);
            $update_columns_array[] = "USER_TIME_TOTAL = FROM_UNIXTIME('$session_total_time')";

        }elseif ($user_track['LAST_LOGON'] > $user_track['USER_TIME_UPDATED']) {

            $session_difference = ($user_track['TIME'] - $user_track['LAST_LOGON']);
            $session_total_time = ($user_track['USER_TIME_TOTAL'] + $session_difference);

            $update_columns_array[] = "USER_TIME_TOTAL = FROM_UNIXTIME('$session_total_time')";

        }elseif ($user_track['TIME'] > $user_track['USER_TIME_UPDATED']) {

            $session_difference = ($user_track['TIME'] - $user_track['USER_TIME_UPDATED']);
            $session_total_time = ($user_track['USER_TIME_TOTAL'] + $session_difference);

            $update_columns_array[] = "USER_TIME_TOTAL = FROM_UNIXTIME('$session_total_time')";
        }

        // We don't update all the time otherwise that would create
        // too much load on the server.

        if ($user_track['TIME'] > ($user_track['USER_TIME_UPDATED'] + $active_sess_cutoff)) {

            // We need to have something to update otherwise
            // the query won't work and MySQL will generate
            // an error which we don't want.            

            if (sizeof($update_columns_array) > 0) {

                $update_columns = implode(", ", $update_columns_array);

                // Try and update first. If it works the number of rows
                // updated will be 1 otherwise we need to try and save
                // the data.

                $sql = "UPDATE {$table_data['PREFIX']}USER_TRACK SET $update_columns, ";
                $sql.= "USER_TIME_UPDATED = NOW() WHERE UID = '$uid'";

                if (!$result = db_query($sql, $db_bh_update_user_time)) return false;

                if (db_affected_rows($db_bh_update_user_time) < 1) {

                    $sql = "INSERT IGNORE INTO {$table_data['PREFIX']}USER_TRACK ";
                    $sql.= "(UID, USER_TIME_BEST, USER_TIME_TOTAL, USER_TIME_UPDATED) ";
                    $sql.= "VALUES ('$uid', FROM_UNIXTIME('$session_length'), ";
                    $sql.= "FROM_UNIXTIME('$session_total_time'), NOW())";

                    if (!$result = db_query($sql, $db_bh_update_user_time)) return false;
                }

                return true;
            }
        }
    }

    return false;
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

    $http_referer = bh_session_get_referer();

    // Delete any guest sessions this user might have.
    
    $user_hash = md5($ipaddress);

    $sql = "DELETE FROM SESSIONS WHERE HASH = '$user_hash'";

    if (!$result = db_query($sql, $db_bh_session_init)) return false;

    // Check for an existing user session.

    $sql = "SELECT HASH FROM SESSIONS WHERE UID = '$uid' ";
    $sql.= "AND IPADDRESS = '$ipaddress'";

    if (!$result = db_query($sql, $db_bh_session_init)) return false;

    if (db_num_rows($result) > 0) {

        list($user_hash) = db_fetch_array($result, DB_RESULT_NUM);

    }else {

        $user_hash = md5(uniqid(rand()));
        
        $ipaddress = db_escape_string($ipaddress);
        $http_referer = db_escape_string($http_referer);

        $sql = "INSERT INTO SESSIONS (HASH, UID, FID, IPADDRESS, TIME, REFERER) ";
        $sql.= "VALUES ('$user_hash', '$uid', '$forum_fid', ";
        $sql.= "'$ipaddress', NOW(), '$http_referer')";

        if (!$result = db_query($sql, $db_bh_session_init)) return false;
    }

    if ($update_visitor_log === true) {
    
        bh_update_visitor_log($uid);
        forum_update_last_visit($uid);
    }

    if ($skip_cookie === false) bh_setcookie('bh_sess_hash', $user_hash);

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
    // Unset the cookies used by Beehive.

    bh_setcookie("bh_sess_hash", "", time() - YEAR_IN_SECONDS);
    bh_setcookie("bh_logon", "1", time() - YEAR_IN_SECONDS);
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
    $db_bh_session_end = db_connect();

    if (($uid = bh_session_get_value('UID')) === false) return false;

    if (!$ipaddress = get_ip_address()) $ipaddress = "";

    // Session cookie

    if (isset($_COOKIE['bh_sess_hash']) && is_md5($_COOKIE['bh_sess_hash'])) {
        $user_hash = $_COOKIE['bh_sess_hash'];
    }else {
        $user_hash = md5($ipaddress);
    }

    if (isset($user_hash)) {

        // If the user isn't a guest we should update how long
        // they have been actively logged in.
        
        if ($uid > 0) bh_update_user_time($uid);

        // Remove the user session.

        $sql = "DELETE FROM SESSIONS WHERE HASH = '$user_hash'";

        if (!$result = db_query($sql, $db_bh_session_end)) return false;
    }

    if ($remove_cookies === true) bh_session_remove_cookies();
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
    $db_bh_session_get_perm_array = db_connect();

    if (!is_numeric($uid)) return false;

    static $user_perm_array = false;

    if (!is_array($user_perm_array) || sizeof($user_perm_array) < 1) {

        if ($table_data = get_table_prefix()) {
            $forum_fid = $table_data['FID'];
        }else {
            $forum_fid = 0;
        }

        $sql = "SELECT GROUP_PERMS.GID, GROUP_PERMS.FORUM, ";
        $sql.= "GROUP_PERMS.FID, BIT_OR(GROUP_PERMS.PERM) AS PERM, ";
        $sql.= "COUNT(GROUP_PERMS.GID) AS USER_PERM_COUNT FROM GROUP_PERMS GROUP_PERMS ";
        $sql.= "LEFT JOIN GROUP_USERS GROUP_USERS ON (GROUP_USERS.GID = GROUP_PERMS.GID) ";
        $sql.= "LEFT JOIN GROUPS GROUPS ON (GROUPS.GID = GROUP_PERMS.GID) ";
        $sql.= "WHERE GROUP_USERS.UID = '$uid' AND GROUP_PERMS.GID IS NOT NULL ";
        $sql.= "GROUP BY GROUP_PERMS.FORUM, GROUP_PERMS.FID";

        if (!$result = db_query($sql, $db_bh_session_get_perm_array)) return false;

        if (db_num_rows($result) > 0) {
            
            if (!is_array($user_perm_array)) $user_perm_array = array();
            
            while ($row = db_fetch_array($result)) {

                if ($row['USER_PERM_COUNT'] > 0) {

                    $user_perm_array[$row['FORUM']][$uid][$row['FID']] = $row['PERM'];
                }
            }
        }

        $sql = "SELECT FORUM, FID, BIT_OR(PERM) AS PERM ";
        $sql.= "FROM GROUP_PERMS WHERE GID = 0 ";
        $sql.= "GROUP BY FORUM, FID";

        if (!$result = db_query($sql, $db_bh_session_get_perm_array)) return false;

        if (db_num_rows($result) > 0) {
            
            if (!is_array($user_perm_array)) $user_perm_array = array();
            
            while ($row = db_fetch_array($result)) {

                if (!isset($user_perm_array[$row['FORUM']][$uid][$row['FID']])) {
                
                    $user_perm_array[$row['FORUM']][$uid][$row['FID']] = $row['PERM'];
                }

                $user_perm_array[$row['FORUM']][0][$row['FID']] = $row['PERM'];
            }
        }
    }

    return is_array($user_perm_array) && sizeof($user_perm_array) > 0 ? $user_perm_array : false;
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

function bh_session_check_perm($perm, $folder_fid)
{
    $user_sess = (isset($GLOBALS['user_sess'])) ? $GLOBALS['user_sess'] : false;

    if (!is_array($user_sess)) return false;
    if (!is_numeric($folder_fid)) return false;

    if (!$table_data = get_table_prefix()) {
        $forum_fid = 0;
    }else {
        $forum_fid = $table_data['FID'];
    }

    $user_perm_test = 0;

    if (($uid = bh_session_get_value('UID')) === false) return false;

    if (user_is_guest()) {

        if (isset($user_sess['PERMS'][$forum_fid][0][$folder_fid])) {
            $user_perm_test = $user_perm_test | $user_sess['PERMS'][$forum_fid][0][$folder_fid];
        }

    }else {

        if (isset($user_sess['PERMS'][$forum_fid][$uid][$folder_fid])) {
            $user_perm_test = $user_perm_test | $user_sess['PERMS'][$forum_fid][$uid][$folder_fid];
        }

        if (isset($user_sess['PERMS'][0][$uid][$folder_fid])) {
            $user_perm_test = $user_perm_test | $user_sess['PERMS'][0][$uid][$folder_fid];
        }

        if (isset($user_sess['PERMS'][0][$uid][0])) {
            $user_perm_test = $user_perm_test | $user_sess['PERMS'][0][$uid][0];
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

    if (($uid = bh_session_get_value('UID')) === false) return false;

    if (user_is_guest()) {

        if (isset($user_sess['PERMS'][$forum_fid][0][$folder_fid])) {
            $user_perm_test = $user_perm_test | $user_sess['PERMS'][$forum_fid][0][$folder_fid];
        }

    }else {

        if (isset($user_sess['PERMS'][$forum_fid][$uid][$folder_fid])) {
            $user_perm_test = $user_perm_test | $user_sess['PERMS'][$forum_fid][$uid][$folder_fid];
        }

        if (isset($user_sess['PERMS'][0][$uid][$folder_fid])) {
            $user_perm_test = $user_perm_test | $user_sess['PERMS'][0][$uid][$folder_fid];
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
    $forum_settings = forum_get_settings();

    if (user_is_guest()) return true;
    if (bh_session_check_perm(USER_PERM_ADMIN_TOOLS, 0)) return true;

    if (forum_get_setting('require_user_approval', 'Y')) {

        if (bh_session_check_perm(USER_PERM_APPROVED, 0)) {
            return true;
        }

        return false;
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

    $user_sess = $GLOBALS['user_sess'];

    $folder_fid_array = array();

    if (($uid = bh_session_get_value('UID')) === false) return false;

    // Test each folder against the provided perm at both the folder
    // and user levels.

    if (isset($user_sess['PERMS'][$forum_fid][$uid]) && is_array($user_sess['PERMS'][$forum_fid][$uid])) {

        foreach($user_sess['PERMS'][$forum_fid][$uid] as $folder_fid => $folder_perm) {

            if (($folder_perm & $perm) == $perm) $folder_fid_array[$folder_fid] = $folder_fid;
        }
    }

    // Folder level permissions.

    if (isset($user_sess['PERMS'][$forum_fid][0]) && is_array($user_sess['PERMS'][$forum_fid][0])) {

        foreach($user_sess['PERMS'][$forum_fid][0] as $folder_fid => $folder_perm) {

            if (($folder_perm & $perm) == $perm) $folder_fid_array[$folder_fid] = $folder_fid;
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
    if (!is_string($sep) || strlen($sep) < 1) $sep = "&";

    $preg_sep = preg_quote($sep, "/");

    $array_keys = array();
    $array_values = array();

    flatten_array($array, $array_keys, $array_values);

    foreach ($array_keys as $key => $key_name) {
        
        if (($key_name != 'webtag') && isset($array_values[$key])) {

            $array_values[$key] = urlencode($array_values[$key]);
            $result_var.= "$key_name={$array_values[$key]}{$sep}";
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

function get_request_uri($include_webtag = true, $encoded_uri_query = true)
{
    if (!is_bool($encoded_uri_query)) $encoded_uri_query = true;

    $webtag = get_webtag($webtag_search);

    if ($encoded_uri_query) {

        if ($include_webtag) {

            $request_uri = "{$_SERVER['PHP_SELF']}?webtag=$webtag&amp;";
            parse_array($_GET, "&amp;", $request_uri);

        }else {

            $request_uri = "{$_SERVER['PHP_SELF']}?";
            parse_array($_GET, "&amp;", $request_uri);
        }

    }else {

        if ($include_webtag) {

            $request_uri = "{$_SERVER['PHP_SELF']}?webtag=$webtag&";
            parse_array($_GET, "&", $request_uri);

        }else {

            $request_uri = "{$_SERVER['PHP_SELF']}?";
            parse_array($_GET, "&", $request_uri);
        }
    }

    // Remove trailing question mark / & / &amp;

    $request_uri = preg_replace("/\?$|&$|&amp;$/", "", $request_uri);
    
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
    $user_sess = (isset($GLOBALS['user_sess'])) ? $GLOBALS['user_sess'] : false;

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
    if (!$http_referer = bh_session_get_value('REFERER')) {

        if (isset($_SERVER['HTTP_REFERER']) && strlen(trim($_SERVER['HTTP_REFERER'])) > 0) {

            $http_referer = trim($_SERVER['HTTP_REFERER']);
            $forum_uri_preg = preg_quote(html_get_forum_uri(), '/');

            if (preg_match("/^$forum_uri_preg/i", $http_referer) > 0) $http_referer = "";
             
        }else {

            $http_referer = "";
        }
    }

    return $http_referer;
}

?>
