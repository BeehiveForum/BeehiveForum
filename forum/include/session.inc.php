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

/* $Id: session.inc.php,v 1.61 2003-11-29 11:37:09 decoyduck Exp $ */

require_once("./include/format.inc.php");
require_once("./include/forum.inc.php");
require_once("./include/config.inc.php");
require_once("./include/user.inc.php");
require_once("./include/ip.inc.php");
require_once("./include/html.inc.php");
require_once("./include/stats.inc.php");

// Array to hold the session.

$user_sess = array();

// Checks the session

function bh_session_check()
{
    global $HTTP_COOKIE_VARS, $show_stats;

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

	$sql = "SELECT SESSIONS.SESSID, SESSIONS.TIME, USER.UID, USER.LOGON, ";
	$sql.= "USER.PASSWD FROM ". forum_table("SESSIONS"). " SESSIONS ";
        $sql.= "LEFT JOIN ". forum_table("USER"). " USER ON (USER.UID = SESSIONS.UID) ";
	$sql.= "WHERE SESSIONS.HASH = '$user_hash'";

	$result = db_query($sql, $db_bh_session_check);

	if (db_num_rows($result) > 0) {

	    $user_sess_check = db_fetch_array($result, MYSQL_ASSOC);

	    if (!isset($user_sess_check['UID']) || (isset($user_sess_check['UID']) && (empty($user_sess_check['UID']) || $user_sess_check['UID'] == 0))) {
	        
	        $user_sess_check['UID']    = 0;
                $user_sess_check['LOGON']  = 'GUEST';
                $user_sess_check['PASSWD'] = md5('GUEST');
	    }

            if (user_check_logon($user_sess_check['UID'], $user_sess_check['LOGON'], $user_sess_check['PASSWD'])) {

                // Everything checks out OK. If the user's session is older
                // then 5 minutes we should update it.

		if ($current_time - $user_sess_check['TIME'] > 300) {

                    $sql = "UPDATE ". forum_table("SESSIONS"). " ";
                    $sql.= "SET IPADDRESS = '$ipaddress', TIME = NOW() ";
                    $sql.= "WHERE SESSID = {$user_sess_check['SESSID']}";

                    db_query($sql, $db_bh_session_check);

                    if ($show_stats) update_stats();
		}

                return true;
            }
	}
    }

    return false;
}

// Fetches a value from the session

function bh_session_get_value($session_key)
{
    global $user_sess;
    
    if (isset($user_sess[$session_key])) return $user_sess[$session_key];

    return false;
}

// Loads the user's session. Needs to be called by each page.

function bh_load_session()
{
    global $HTTP_COOKIE_VARS, $default_style, $default_language, $user_sess;

    $db_bh_session_get_value = db_connect();

    if (isset($HTTP_COOKIE_VARS['bh_sess_hash']) && is_md5($HTTP_COOKIE_VARS['bh_sess_hash'])) {

        $user_hash = $HTTP_COOKIE_VARS['bh_sess_hash'];

	$sql = "SELECT USER.UID, USER.LOGON, USER.PASSWD, USER.STATUS, USER_PREFS.POSTS_PER_PAGE, USER_PREFS.TIMEZONE, ";
        $sql.= "USER_PREFS.DL_SAVING, USER_PREFS.MARK_AS_OF_INT, USER_PREFS.FONT_SIZE, USER_PREFS.STYLE, ";
        $sql.= "USER_PREFS.VIEW_SIGS, USER_PREFS.START_PAGE, USER_PREFS.LANGUAGE, USER_PREFS.PM_NOTIFY, USER_PREFS.SHOW_STATS ";
        $sql.= "FROM ". forum_table("USER"). " USER ";
        $sql.= "LEFT JOIN ". forum_table("USER_PREFS"). " USER_PREFS ON (USER.UID = USER_PREFS.UID) ";
        $sql.= "LEFT JOIN ". forum_table("SESSIONS"). " SESSIONS ON (USER.UID = SESSIONS.UID) ";
	$sql.= "WHERE SESSIONS.HASH = '$user_hash'";

	$result = db_query($sql, $db_bh_session_get_value);

	if (db_num_rows($result) > 0) {

	    $user_sess = db_fetch_array($result, MYSQL_ASSOC);

	}else {

            $user_sess = array('UID'            => 0,
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
	}
    }
}

// Initialises the session

function bh_session_init($uid)
{
    global $HTTP_SERVER_VARS, $default_style, $default_language;

    $db_bh_session_init = db_connect();
    $ipaddress = get_ip_address();

    if ($uid > 0) {

        // If we're not logging in as a guest we should delete any
	// old sessions for this UID.

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
	    // old sessions for this UID.

            $sql = "DELETE FROM ". forum_table("SESSIONS"). " WHERE UID = $uid";
	    $result = db_query($sql, $db_bh_session_end);
        }

        $user_hash = $HTTP_COOKIE_VARS['bh_sess_hash'];

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

// Load the user's session data into a variable to
// save querying multiple times each page.

bh_load_session();

?>