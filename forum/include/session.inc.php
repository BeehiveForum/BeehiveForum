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

/* $Id: session.inc.php,v 1.81 2004-03-13 00:00:22 decoyduck Exp $ */

include_once("./include/db.inc.php");
include_once("./include/format.inc.php");
include_once("./include/ip.inc.php");
include_once("./include/stats.inc.php");
include_once("./include/user.inc.php");

// Checks the session and returns it as an array.

function bh_session_check()
{
    global $HTTP_COOKIE_VARS, $session_cutoff, $show_stats, $default_language, $default_style;
    
    if (!isset($default_style)) $default_style = "default";
    if (!isset($default_language)) $default_language = "en";
    if (!isset($show_stats)) $show_stats = true;
    if (!isset($session_cutoff)) $session_cutoff = 86400;

    //ip_check();

    $db_bh_session_check = db_connect();
    $ipaddress = get_ip_address();
    
    $table_prefix = get_webtag(true);
    $forum_webtag = get_webtag();

    // Current server time.

    $current_time = time();

    // Check the current user's session data. This is the main session
    // data that Beehive relies on. If this data does not match what
    // we have stored in the database then the user gets logged out
    // automatically.

    if (isset($HTTP_COOKIE_VARS['bh_sess_hash']) && is_md5($HTTP_COOKIE_VARS['bh_sess_hash'])) {

        $user_hash = $HTTP_COOKIE_VARS['bh_sess_hash'];

	$sql = "SELECT USER_PREFS.*, USER.LOGON, USER.PASSWD, USER.STATUS, ";
	$sql.= "SESSIONS.UID, SESSIONS.SESSID, SESSIONS.TIME, SESSIONS.WEBTAG FROM SESSIONS SESSIONS ";
	$sql.= "LEFT JOIN USER USER ON (USER.UID = SESSIONS.UID) ";
        $sql.= "LEFT JOIN {$table_prefix}USER_PREFS USER_PREFS ON (USER_PREFS.UID = USER.UID) ";
	$sql.= "WHERE SESSIONS.HASH = '$user_hash'";

	$result = db_query($sql, $db_bh_session_check);

	if (db_num_rows($result) > 0) {
	    
	    $user_sess = db_fetch_array($result, MYSQL_ASSOC);

	    if (isset($user_sess['UID']) && $user_sess['UID'] == 0) {

                $guest_user_sess = array('UID'              => 0,
                                         'LOGON'            => 'GUEST',
                                         'PASSWD'           => md5('GUEST'),
                                         'STATUS'           => 0,
                                         'POSTS_PER_PAGE'   => 5,
                                         'TIMEZONE'         => 0,
                                         'DL_SAVING'        => 0,
                                         'MARK_AS_OF_INT'   => 0,
                                         'FONT_SIZE'        => 10,
                                         'STYLE'            => $default_style,
                                         'VIEW_SIGS'        => 0,
                                         'START_PAGE'       => 0,
                                         'LANGUAGE'         => $default_language,
                                         'PM_NOTIFY'        => 'N',
                                         'SHOW_STATS'       => 1,
                                         'IMAGES_TO_LINKS'  => 'N',
                                         'USE_WORD_FILTER'  => 'Y',
                                         'USE_ADMIN_FILTER' => 'Y');

		$user_sess = array_merge($user_sess, $guest_user_sess);
	    }

	    if (isset($user_sess['UID']) && isset($user_sess['LOGON']) && isset($user_sess['PASSWD'])) {

                if (user_check_logon($user_sess['UID'], $user_sess['LOGON'], $user_sess['PASSWD'])) {
                
                    // If the user is not logged into the current forum, we should
                    // do that now for them.
                    
                    if (strtoupper($user_sess['WEBTAG']) != strtoupper($forum_webtag)) {
                    
                        $sql = "SELECT * FROM SESSIONS WHERE HASH = '$user_hash' AND WEBTAG = '$forum_webtag'";
                        $result = db_query($sql, $db_bh_session_check);
                        
                        if (db_num_rows($result) == 0) {
                        
                            $sql = "INSERT INTO SESSIONS (HASH, UID, IPADDRESS, TIME, WEBTAG) ";
                            $sql.= "VALUES ('$user_hash', '{$user_sess['UID']}', '$ipaddress', NOW(), '$forum_webtag')";
                        
                            $result = db_query($sql, $db_bh_session_check);
                        }
                    }

                    // Everything checks out OK. If the user's session is older
                    // then 5 minutes we should update it.

		    if ($current_time - $user_sess['TIME'] > 60) {
                        
                        // Update the session
                        
                        $sql = "UPDATE SESSIONS ";
                        $sql.= "SET IPADDRESS = '$ipaddress', TIME = NOW(), WEBTAG = '$forum_webtag' ";
                        $sql.= "WHERE SESSID = {$user_sess['SESSID']} AND WEBTAG = '$forum_webtag'";
  
                        db_query($sql, $db_bh_session_check);

  			// Delete expires sessions 			

                        $session_stamp = time() - $session_cutoff;  			

                        $sql = "DELETE FROM SESSIONS WHERE ";
                        $sql.= "TIME < FROM_UNIXTIME($session_stamp)";

                        db_query($sql, $db_bh_session_check);

                        if ($show_stats) update_stats();
		    }

                    return $user_sess;
		}
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

// Initialises the session

function bh_session_init($uid)
{
    global $HTTP_COOKIE_VARS, $session_cutoff;
    
    if (!isset($session_cutoff)) $session_cutoff = 86400;

    $db_bh_session_init = db_connect();
    $ipaddress = get_ip_address();
    
    $table_prefix = get_webtag(true);
    $forum_webtag = get_webtag();
    
    $session_stamp = time() - $session_cutoff;

    // Delete expires sessions

    $sql = "DELETE FROM SESSIONS WHERE ";
    $sql.= "TIME < FROM_UNIXTIME($session_stamp)";

    db_query($sql, $db_bh_session_init);

    // Generate a unique random MD5 hash for the user's cookie
    // from their IP Address.

    $user_hash = md5(uniqid($ipaddress));

    $sql = "INSERT INTO SESSIONS (HASH, UID, IPADDRESS, TIME, WEBTAG) ";
    $sql.= "VALUES ('$user_hash', '$uid', '$ipaddress', NOW(), '$forum_webtag')";

    $result = db_query($sql, $db_bh_session_init);

    bh_setcookie('bh_sess_hash', $user_hash);
}

// Ends the session by deleting the session data and and the cookie hash.

function bh_session_end()
{
    global $HTTP_COOKIE_VARS;

    $db_bh_session_end = db_connect();
    
    $table_prefix = get_webtag(true);

    if (isset($HTTP_COOKIE_VARS['bh_sess_hash'])) {

        $user_hash = $HTTP_COOKIE_VARS['bh_sess_hash'];

        // Delete the session for the current MD5 hash
        
        $sql = "DELETE FROM SESSIONS WHERE HASH = '$user_hash'";
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
        $request_uri = $HTTP_SERVER_VARS['REQUEST_URI'];
    }else {
        $request_uri = "{$HTTP_SERVER_VARS['PHP_SELF']}?";
        foreach ($HTTP_GET_VARS as $key => $value) {
            $request_uri.= "{$key}=". rawurlencode($value). "&";
        }
    }
    
    // Fix the slashes for forum running from sub-domain.
    // Rather dirty hack this, but it's the only idea I've got.
    // Any suggestions are welcome on how to handle this better.
    
    $request_uri = preg_replace("/\/\/+/", "/", $request_uri);
    return $request_uri;
}

?>