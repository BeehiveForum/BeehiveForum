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

/* $Id: session.inc.php,v 1.66 2003-11-30 19:26:00 decoyduck Exp $ */

require_once("./include/format.inc.php");
require_once("./include/forum.inc.php");
require_once("./include/config.inc.php");
require_once("./include/user.inc.php");
require_once("./include/ip.inc.php");
require_once("./include/html.inc.php");
require_once("./include/stats.inc.php");

// Checks the session and loads it into an array.

function bh_session_check()
{
    global $HTTP_COOKIE_VARS, $show_stats, $session_cutoff;

    ip_check();

    $db_bh_session_check = db_connect();
    $ipaddress = get_ip_address();

    // Current server time.

    $current_time = time();

    // Check the current user's cookie data. This is the main session
    // data that Beehive relies on. We only store something in the
    // SESSIONS table in the database for user tracking purposes, e.g:
    // Active User list, etc.

    if (isset($HTTP_COOKIE_VARS['bh_sess_hash']) && is_md5($HTTP_COOKIE_VARS['bh_sess_hash'])) {

        $user_hash = $HTTP_COOKIE_VARS['bh_sess_hash'];

	$sql = "SELECT SESSIONS.UID, SESSIONS.SESSID, SESSIONS.TIME, USER.LOGON, ";
	$sql.= "USER.PASSWD, USER.STATUS FROM ". forum_table("SESSIONS"). " SESSIONS ";
	$sql.= "LEFT JOIN ". forum_table("USER"). " USER ON (USER.UID = SESSIONS.UID) ";
	$sql.= "WHERE SESSIONS.HASH = '$user_hash'";

	$result = db_query($sql, $db_bh_session_check);

	if (db_num_rows($result) > 0) {
	    
	    $user_sess_check = db_fetch_array($result, MYSQL_ASSOC);

	    if (isset($user_sess_check['UID']) && $user_sess_check['UID'] == 0) {

                $user_sess_check['LOGON']  = 'GUEST';
		$user_sess_check['PASSWD'] = md5('GUEST');
	    }

	    if (isset($user_sess_check['UID']) && isset($user_sess_check['LOGON']) && isset($user_sess_check['PASSWD'])) {

                if (user_check_logon($user_sess_check['UID'], $user_sess_check['LOGON'], $user_sess_check['PASSWD'])) {

                    // Everything checks out OK. If the user's session is older
                    // then 5 minutes we should update it.

		    if ($current_time - $user_sess_check['TIME'] > 60) {

                        $session_stamp = time() - $session_cutoff;
                        
                        // Update the session
                        
                        $sql = "UPDATE ". forum_table("SESSIONS"). " ";
                        $sql.= "SET IPADDRESS = '$ipaddress', TIME = NOW() ";
                        $sql.= "WHERE SESSID = {$user_sess_check['SESSID']}";

                        db_query($sql, $db_bh_session_check);

  			// Delete expires sessions

                        $sql = "DELETE FROM ". forum_table("SESSIONS"). " WHERE ";
                        $sql.= "TIME < FROM_UNIXTIME($session_stamp) AND UID = 0";

                        db_query($sql, $db_bh_session_check);

                        if ($show_stats) update_stats();
		    }

                    return true;
		}
            }
	}
    }

    return false;
}

// Fetches a value from the session

function bh_session_get_value($session_key)
{
    global $HTTP_COOKIE_VARS, $default_style, $default_language;

    if (isset($HTTP_COOKIE_VARS['bh_sess_hash']) && is_md5($HTTP_COOKIE_VARS['bh_sess_hash'])) {

        $db_bh_session_get_value = db_connect();

        $user_hash = $HTTP_COOKIE_VARS['bh_sess_hash'];

        $sql = "SELECT USER_PREFS.*, USER.LOGON, USER.PASSWD, USER.STATUS, SESSIONS.UID ";
        $sql.= "FROM ". forum_table("SESSIONS"). " SESSIONS ";
	$sql.= "LEFT JOIN ". forum_table("USER"). " USER ON (USER.UID = SESSIONS.UID) ";
        $sql.= "LEFT JOIN ". forum_table("USER_PREFS"). " USER_PREFS ON (USER_PREFS.UID = USER.UID) ";
        $sql.= "WHERE SESSIONS.HASH = '$user_hash'";

        $result = db_query($sql, $db_bh_session_get_value);

        if (db_num_rows($result) > 0) {

            $user_sess_get = db_fetch_array($result, MYSQL_ASSOC);

	    if (isset($user_sess_get['UID']) && $user_sess_get['UID'] == 0) {

                $guest_user_sess = array('UID'            => 0,
                                         'LOGON'          => 'GUEST',
                                         'PASSWD'         => md5('GUEST'),
                                         'STATUS'         => 0,
                                         'POSTS_PER_PAGE' => 5,
                                         'TIMEZONE'       => 0,
                                         'DL_SAVING'      => 0,
                                         'MARK_AS_OF_INT' => 0,
                                         'FONT_SIZE'      => 10,
                                         'STYLE'          => $default_style,
                                         'VIEW_SIGS'      => 0,
                                         'START_PAGE'     => 0,
                                         'LANGUAGE'       => $default_language,
                                         'PM_NOTIFY'      => 'N',
                                         'SHOW_STATS'     => 1);

		$user_sess_get = array_merge($user_sess_get, $guest_user_sess);
	    }

            if (isset($user_sess_get[$session_key])) return $user_sess_get[$session_key];
        }
    }

    return false;
}

// Initialises the session

function bh_session_init($uid)
{
    global $HTTP_COOKIE_VARS;

    $db_bh_session_init = db_connect();
    $ipaddress = get_ip_address();

    if ($uid > 0) {

        // If we're not logging in as a guest we should delete any
	// stale sessions for this UID.

        $sql = "DELETE FROM ". forum_table("SESSIONS"). " WHERE UID = $uid";
	$result = db_query($sql, $db_bh_session_init);
    }

    // Generate a unique random MD5 hash for the user's cookie
    // from their IP Address.

    $user_hash = md5(uniqid($ipaddress));

    $sql = "INSERT INTO ". forum_table("SESSIONS"). " (HASH, UID, IPADDRESS, TIME) ";
    $sql.= "VALUES ('$user_hash', '$uid', '$ipaddress', NOW())";

    $result = db_query($sql, $db_bh_session_init);

    bh_setcookie('bh_sess_hash', $user_hash);
}

// Ends the session by deleting the session data and and the cookie hash.

function bh_session_end()
{
    global $HTTP_COOKIE_VARS;

    $db_bh_session_end = db_connect();

    if (isset($HTTP_COOKIE_VARS['bh_sess_hash'])) {

        $uid = bh_session_get_value('UID'); 

        if ($uid > 0) {

            // If we're not logged in as a guest we should delete any
	    // stale sessions for this UID.

            $sql = "DELETE FROM ". forum_table("SESSIONS"). " WHERE UID = $uid";
	    $result = db_query($sql, $db_bh_session_end);
        }

        $user_hash = $HTTP_COOKIE_VARS['bh_sess_hash'];

        // Delete the session for the current MD5 hash
        
        $sql = "DELETE FROM ". forum_table("SESSIONS"). " WHERE HASH = '$user_hash'";
        $result = db_query($sql, $db_bh_session_end);
    }

    // Session cookie

    bh_setcookie("bh_sess_hash", "", time() - YEAR_IN_SECONDS);

    // Other cookies set by Beehive

    bh_setcookie("bh_thread_mode", "", time() - YEAR_IN_SECONDS);
}

// IIS does not support the REQUEST_URI server var, so we will make one for it
function get_request_uri()
{
    global $HTTP_SERVER_VARS, $HTTP_GET_VARS;

    if (isset($HTTP_SERVER_VARS['REQUEST_URI'])) {
        return $HTTP_SERVER_VARS['REQUEST_URI'];
    }else {
        $request_uri = $HTTP_SERVER_VARS['PHP_SELF']. "?";
        foreach ($HTTP_GET_VARS as $key => $value) {
            $request_uri.= "{$key}=". rawurlencode($value). "&";
        }
        return $request_uri;
    }
}

?>