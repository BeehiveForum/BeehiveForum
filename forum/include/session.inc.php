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

/* $Id: session.inc.php,v 1.124 2004-09-08 01:55:35 tribalonline Exp $ */

include_once("./include/db.inc.php");
include_once("./include/format.inc.php");
include_once("./include/forum.inc.php");
include_once("./include/ip.inc.php");
include_once("./include/stats.inc.php");
include_once("./include/user.inc.php");

// Checks the session and returns it as an array.

function bh_session_check($add_guest_sess = true)
{
    ip_check();

    $db_bh_session_check = db_connect();
    $ipaddress = get_ip_address();

    $forum_settings = get_forum_settings();

    // Current server time.

    $current_time = time();

    // Session cut off timestamp

    $session_stamp = time() - intval(forum_get_setting('session_cutoff'));

    // Check the current user's session data. This is the main session
    // data that Beehive relies on. If this data does not match what
    // we have stored in the database then the user gets logged out
    // automatically.

    if (isset($_COOKIE['bh_sess_hash']) && is_md5($_COOKIE['bh_sess_hash'])) {

        $user_hash = $_COOKIE['bh_sess_hash'];

        if ($table_data = get_table_prefix()) {


	    $sql = "SELECT USER.LOGON, USER.PASSWD, ";
	    $sql.= "BIT_OR(GROUP_PERMS.PERM) AS STATUS, ";
        $sql.= "COUNT(GROUP_PERMS.GID) AS USER_PERM_COUNT, ";
	    $sql.= "SESSIONS.UID, SESSIONS.SESSID, UNIX_TIMESTAMP(SESSIONS.TIME) AS TIME, ";
	    $sql.= "SESSIONS.FID FROM SESSIONS SESSIONS ";
	    $sql.= "LEFT JOIN USER USER ON (USER.UID = SESSIONS.UID) ";
	    $sql.= "LEFT JOIN {$table_data['PREFIX']}GROUP_USERS GROUP_USERS ";
	    $sql.= "ON (GROUP_USERS.UID = SESSIONS.UID) ";
	    $sql.= "LEFT JOIN {$table_data['PREFIX']}GROUP_PERMS GROUP_PERMS ";
	    $sql.= "ON (GROUP_PERMS.GID = GROUP_USERS.GID AND GROUP_PERMS.FID = 0) ";
	    $sql.= "WHERE SESSIONS.HASH = '$user_hash' ";
	    $sql.= "GROUP BY USER.UID";

        }else {

            $sql = "SELECT USER.LOGON, USER.PASSWD, SESSIONS.UID, ";
            $sql.= "SESSIONS.SESSID, UNIX_TIMESTAMP(SESSIONS.TIME) AS TIME, ";
            $sql.= "SESSIONS.FID FROM SESSIONS SESSIONS ";
            $sql.= "LEFT JOIN USER USER ON (USER.UID = SESSIONS.UID) ";
            $sql.= "WHERE SESSIONS.HASH = '$user_hash'";
        }

        $result = db_query($sql, $db_bh_session_check);

        if (db_num_rows($result) > 0) {

            $user_sess = db_fetch_array($result, MYSQL_ASSOC);

			// Add preference settings
	        $user_sess = array_merge($user_sess, user_get_prefs($user_sess['UID']));
	
			// We need to check here to see if the user is
		    // banned from this forum as the login check
		    // may have failed because they weren't logging
		    // in to a specific forum.

            if ($user_sess['USER_PERM_COUNT'] > 0 && $user_sess['STATUS'] & USER_PERM_BANNED) {

                if (!strstr(php_sapi_name(), 'cgi')) {
                    header("HTTP/1.0 500 Internal Server Error");
                }else {
                    echo "<h1>HTTP/1.0 500 Internal Server Error</h1>\n";
                }
                exit;
            }

            if (is_numeric($table_data['FID'])) {

                // If the user is not logged into the current forum, we should
                // do that now for them.

                if ($user_sess['FID'] != $table_data['FID']) {

                    $sql = "DELETE FROM SESSIONS WHERE HASH = '$user_hash' ";
                    $sql.= "AND FID = '{$table_data['FID']}'";

                    $result = db_query($sql, $db_bh_session_check);

                    $sql = "INSERT INTO SESSIONS (HASH, UID, FID, IPADDRESS, TIME) ";
                    $sql.= "VALUES ('$user_hash', '{$user_sess['UID']}', '{$table_data['FID']}', ";
                    $sql.= "'$ipaddress', NOW())";

                    $result = db_query($sql, $db_bh_session_check);

                    $sql = "SELECT LAST_LOGON FROM VISITOR_LOG ";
                    $sql.= "WHERE UID = {$user_sess['UID']} AND FID = {$table_data['FID']}";

                    $result = db_query($sql, $db_bh_session_check);

                    if (db_num_rows($result) > 0) {

                        $sql = "UPDATE VISITOR_LOG SET LAST_LOGON = NOW() ";
                        $sql.= "WHERE UID = {$user_sess['UID']} AND FID = {$table_data['FID']}";

                        $result = db_query($sql, $db_bh_session_check);

                    }else {

                        $sql = "INSERT INTO VISITOR_LOG (UID, FID, LAST_LOGON) ";
                        $sql.= "VALUES ({$user_sess['UID']}, {$table_data['FID']}, NOW())";

                        $result = db_query($sql, $db_bh_session_check);
                    }
                }

                // Everything checks out OK. If the user's session is older
                // then 5 minutes we should update it.

                if ($current_time - $user_sess['TIME'] > 300) {

                    // Update the session for the current forum

                    $sql = "UPDATE SESSIONS ";
                    $sql.= "SET IPADDRESS = '$ipaddress', TIME = NOW(), FID = '{$table_data['FID']}' ";
                    $sql.= "WHERE SESSID = {$user_sess['SESSID']} AND FID = '{$table_data['FID']}'";

                    $result = db_query($sql, $db_bh_session_check);
                }

            }else {

                // Everything checks out OK. If the user's session is older
                // then 5 minutes we should update it.

                if ($current_time - $user_sess['TIME'] > 300) {

                    // Update the main user session

                    $sql = "UPDATE SESSIONS ";
                    $sql.= "SET IPADDRESS = '$ipaddress', TIME = NOW() ";
                    $sql.= "WHERE SESSID = {$user_sess['SESSID']}";

                    $result = db_query($sql, $db_bh_session_check);
                }
            }

            // Delete expires sessions

            $session_stamp = time() - intval(forum_get_setting('session_cutoff'));

            $sql = "DELETE FROM SESSIONS WHERE ";
            $sql.= "TIME < FROM_UNIXTIME($session_stamp)";

            db_query($sql, $db_bh_session_check);

            if (forum_get_setting('show_stats', 'Y', false) && $table_data) {
                update_stats();
            }

            return $user_sess;

        }else {

            return false;
        }
    }

    if ($add_guest_sess) {

        // Guest user sessions are handled a bit differently.

        if (!$table_data = get_table_prefix()) $table_data['FID'] = 0;

        $sql = "SELECT SESSIONS.SESSID, UNIX_TIMESTAMP(SESSIONS.TIME) AS TIME, ";
        $sql.= "SESSIONS.FID FROM SESSIONS SESSIONS WHERE SESSIONS.UID = 0 ";
        $sql.= "AND SESSIONS.IPADDRESS = '$ipaddress' ";
        $sql.= "AND SESSIONS.FID = '{$table_data['FID']}'";

        $result = db_query($sql, $db_bh_session_check);

        if (db_num_rows($result) > 0) {

            $user_sess = db_fetch_array($result, MYSQL_ASSOC);

            if ($current_time - $user_sess['TIME'] > 300) {

                $sql = "UPDATE SESSIONS SET TIME = NOW(), FID = '{$table_data['FID']}' ";
                $sql.= "WHERE SESSID = {$user_sess['SESSID']} AND FID = '{$table_data['FID']}'";

                $result = db_query($sql, $db_bh_session_check);
            }

        }else {

            $sql = "INSERT INTO SESSIONS (UID, FID, IPADDRESS, TIME) ";
            $sql.= "VALUES (0, '{$table_data['FID']}', '$ipaddress', NOW())";

            $result = db_query($sql, $db_bh_session_check);
        }
    }

    return array('UID'              => 0,
                 'LOGON'            => 'GUEST',
                 'PASSWD'           => md5('GUEST'),
                 'STATUS'           => 0,
                 'POSTS_PER_PAGE'   => 20,
                 'TIMEZONE'         => 0,
                 'DL_SAVING'        => 0,
                 'MARK_AS_OF_INT'   => 0,
                 'FONT_SIZE'        => 10,
                 'STYLE'            => forum_get_setting('default_style'),
                 'VIEW_SIGS'        => 'Y',
                 'START_PAGE'       => 0,
                 'LANGUAGE'         => forum_get_setting('default_language'),
                 'PM_NOTIFY'        => 'N',
                 'SHOW_STATS'       => 1,
                 'IMAGES_TO_LINKS'  => 'N',
                 'USE_WORD_FILTER'  => 'Y',
                 'USE_ADMIN_FILTER' => 'Y',
                 'POST_PAGE'            => 0);
}

// Fetches a value from the session

function bh_session_get_value($session_key)
{
    global $user_sess;

    if (isset($user_sess[$session_key])) return $user_sess[$session_key];
    if (strtoupper($session_key) == 'UID') return 0;

    return false;
}

// Initialises the session

function bh_session_init($uid)
{
    $db_bh_session_init = db_connect();
    $ipaddress = get_ip_address();

    if (!$table_data = get_table_prefix()) $table_data['FID'] = 0;

    $forum_settings = get_forum_settings();

    $session_stamp = time() - intval(forum_get_setting('session_cutoff'));

    // Delete expires sessions

    $sql = "DELETE FROM SESSIONS WHERE ";
    $sql.= "TIME < FROM_UNIXTIME($session_stamp)";

    db_query($sql, $db_bh_session_init);

    // Generate a unique random MD5 hash for the user's cookie
    // from their IP Address.

    $user_hash = md5(uniqid($ipaddress));

    $sql = "INSERT INTO SESSIONS (HASH, UID, FID, IPADDRESS, TIME) ";
    $sql.= "VALUES ('$user_hash', '$uid', '{$table_data['FID']}', ";
    $sql.= "'$ipaddress', NOW())";

    $result = db_query($sql, $db_bh_session_init);

    $sql = "SELECT LAST_LOGON FROM VISITOR_LOG ";
    $sql.= "WHERE UID = $uid AND FID = {$table_data['FID']}";

    $result = db_query($sql, $db_bh_session_init);

    if (db_num_rows($result) > 0) {

        $sql = "UPDATE VISITOR_LOG SET LAST_LOGON = NOW() ";
        $sql.= "WHERE UID = $uid AND FID = {$table_data['FID']}";

        $result = db_query($sql, $db_bh_session_init);

    }else {

        $sql = "INSERT INTO VISITOR_LOG (UID, FID, LAST_LOGON) ";
        $sql.= "VALUES ($uid, {$table_data['FID']}, NOW())";

        $result = db_query($sql, $db_bh_session_init);
    }

    bh_setcookie('bh_sess_hash', $user_hash);
}

// Ends the session by deleting the session data and and the cookie hash.

function bh_session_end()
{
    $db_bh_session_end = db_connect();

    if (isset($_COOKIE['bh_sess_hash'])) {

        $user_hash = $_COOKIE['bh_sess_hash'];

        // Delete the session for the current MD5 hash

        $sql = "DELETE FROM SESSIONS WHERE HASH = '$user_hash'";
        $result = db_query($sql, $db_bh_session_end);
    }

    // Session cookie

    bh_setcookie("bh_sess_hash", "", time() - YEAR_IN_SECONDS);

    // Other cookies set by Beehive

    bh_setcookie("bh_thread_mode", "", time() - YEAR_IN_SECONDS);

    bh_setcookie("bh_logon", "", time() - YEAR_IN_SECONDS);
}

// IIS does not support the REQUEST_URI server var, so we will make one for it
function get_request_uri($rawurlencode = false)
{
    $request_uri = "{$_SERVER['PHP_SELF']}?";

    foreach ($_GET as $key => $value) {
        $request_uri.= "{$key}=". rawurlencode($value). "&";
    }

    // Fix the slashes for forum running from sub-domain.
    // Rather dirty hack this, but it's the only idea I've got.
    // Any suggestions are welcome on how to handle this better.

    $request_uri = preg_replace("/\/\/+/", "/", $request_uri);

    if ($rawurlencode) {
        return rawurlencode($request_uri);
    }else {
        return $request_uri;
    }
}

function bh_session_get_post_page_prefs()
{
	$page_prefs = bh_session_get_value('POST_PAGE');

	if (!($page_prefs > 0)) {
		$page_prefs = POST_TOOLBAR_DISPLAY | POST_EMOTICONS_DISPLAY | POST_TEXT_DEFAULT | POST_AUTO_LINKS | POST_DISPLAY_SIGNATURE;
	}

	return $page_prefs;
}

?>
