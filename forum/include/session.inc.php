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

/* $Id: session.inc.php,v 1.54 2003-10-18 17:21:06 decoyduck Exp $ */

require_once("./include/forum.inc.php");
require_once("./include/config.inc.php");
require_once("./include/user.inc.php");
require_once("./include/format.inc.php");
require_once("./include/ip.inc.php");
require_once("./include/html.inc.php");
require_once("./include/stats.inc.php");

// Checks the session

function bh_session_check()
{
    global $HTTP_COOKIE_VARS;

    ip_check();

    $db_bh_session_check = db_connect();
    $ipaddress = get_ip_address();

    // Check the current user's cookie data. This is the main session
    // data that Beehive relies on. We only store something in the
    // SESSIONS table in the database for user tracking purposes, e.g:
    // Active User list, etc.

    if (isset($HTTP_COOKIE_VARS['bh_sess_data']) && isset($HTTP_COOKIE_VARS['bh_sess_check'])) {

        $user_sess = _stripslashes($HTTP_COOKIE_VARS['bh_sess_data']);
        $user_hash = $HTTP_COOKIE_VARS['bh_sess_check'];

        if (md5($user_sess) == $user_hash) {

            $user_sess = unserialize(_stripslashes($HTTP_COOKIE_VARS['bh_sess_data']));

            if (user_check_logon($user_sess['UID'], $user_sess['LOGON'], $user_sess['PASSWD'])) {

                // Everything checks out OK, update the user's SESSION entry
                // in the database.

                if ($user_sess['UID'] > 0) {

                    $sql = "SELECT SESSID FROM ". forum_table("SESSIONS"). " ";
                    $sql.= "WHERE UID = {$user_sess['UID']}";

                    $result = db_query($sql, $db_bh_session_check);

                    if (db_num_rows($result)) {

                        $sess_array = db_fetch_array($result);

                        $sql = "UPDATE ". forum_table("SESSIONS"). " ";
                        $sql.= "SET IPADDRESS = '$ipaddress', TIME = NOW() ";
                        $sql.= "WHERE SESSID = {$sess_array['SESSID']}";

                    }else {

                        $sql = "INSERT INTO ". forum_table("SESSIONS"). " (UID, IPADDRESS, TIME) ";
                        $sql.= "VALUES ('{$user_sess['UID']}', '$ipaddress', NOW())";
                    }

                }else {

                    $sql = "SELECT SESSID FROM ". forum_table("SESSIONS"). " ";
                    $sql.= "WHERE IPADDRESS = '$ipaddress'";

                    $result = db_query($sql, $db_bh_session_check);

                    if (db_num_rows($result)) {

                        $sess_array = db_fetch_array($result);

                        $sql = "UPDATE ". forum_table("SESSIONS"). " ";
                        $sql.= "SET IPADDRESS = '$ipaddress', TIME = NOW() ";
                        $sql.= "WHERE SESSID = {$sess_array['SESSID']}";

                    }else {

                        $sql = "INSERT INTO ". forum_table("SESSIONS"). " (UID, IPADDRESS, TIME) ";
                        $sql.= "VALUES ('{$user_sess['UID']}', '$ipaddress', NOW())";
                    }
                }

                db_query($sql, $db_bh_session_check);
                bh_remove_stale_sessions();
                update_stats();
                return true;
            }
        }
    }

    return false;
}

// Remove all active users that are over the $session_cutoff in age.

function bh_remove_stale_sessions()
{
    global $session_cutoff;

    $db_bh_update_session_stats = db_connect();

    $session_stamp = time() - $session_cutoff;

    $sql = "DELETE FROM ". forum_table("SESSIONS"). " WHERE TIME < $session_stamp";
    $result = db_query($sql, $db_bh_update_session_stats);
}

// Fetches a value from the session

function bh_session_get_value($session_key)
{
    global $HTTP_COOKIE_VARS;

    if (isset($HTTP_COOKIE_VARS['bh_sess_data'])) {
        $user_sess = unserialize(_stripslashes($HTTP_COOKIE_VARS['bh_sess_data']));
        if (in_array($session_key, array_keys($user_sess))) {
            return $user_sess[$session_key];
        }
    }

    return false;
}

// Initialises the session

function bh_session_init($uid)
{
    global $HTTP_SERVER_VARS, $default_style, $default_language;

    $db_bh_session_init = db_connect();
    $ipaddress = get_ip_address();

    if ($uid > 0) {

        $sql = "DELETE FROM ". forum_table("SESSIONS"). " WHERE ";
        $sql.= "IPADDRESS = '$ipaddress' OR UID = '$uid'";

        $result = db_query($sql, $db_bh_session_init);

    }else {

        $sql = "DELETE FROM ". forum_table("SESSIONS"). " WHERE IPADDRESS = '$ipaddress'";
        $result = db_query($sql, $db_bh_session_init);
    }

    $sql = "INSERT INTO ". forum_table("SESSIONS"). " (UID, IPADDRESS, TIME) ";
    $sql.= "VALUES ('$uid', '$ipaddress', NOW())";

    $result = db_query($sql, $db_bh_session_init);

    $sql = "select USER.UID, USER.LOGON, USER.PASSWD, USER.STATUS, USER_PREFS.POSTS_PER_PAGE, USER_PREFS.TIMEZONE, ";
    $sql.= "USER_PREFS.DL_SAVING, USER_PREFS.MARK_AS_OF_INT, USER_PREFS.FONT_SIZE, USER_PREFS.STYLE, ";
    $sql.= "USER_PREFS.VIEW_SIGS, USER_PREFS.START_PAGE, USER_PREFS.LANGUAGE, USER_PREFS.PM_NOTIFY, USER_PREFS.SHOW_STATS ";
    $sql.= "from " . forum_table("USER") . " USER left join " . forum_table("USER_PREFS") . " USER_PREFS on (USER.UID = USER_PREFS.UID) ";
    $sql.= "where USER.UID = $uid";

    $result = db_query($sql, $db_bh_session_init);

    if (db_num_rows($result) && $uid > 0) {

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

    $check = md5(serialize($user_sess));

    bh_setcookie("bh_sess_data", serialize($user_sess));
    bh_setcookie("bh_sess_check", $check);

}

// Ends the session by deleting the cookie data and scrambling the MD5 check.

function bh_session_end()
{
    // Delete the session data from the database

    $db_bh_session_end = db_connect();

    $ipaddress = get_ip_address();

    if ($uid = bh_session_get_value('UID')) {

        $sql = "DELETE FROM ". forum_table("SESSIONS"). " WHERE UID = $uid ";
        $sql.= "AND IPADDRESS = '$ipaddress'";

    }else {

        $sql = "DELETE FROM ". forum_table("SESSIONS"). " WHERE IPADDRESS = '$ipaddress'";
    }

    $result = db_query($sql, $db_bh_session_end);

    // Session cookies

    bh_setcookie("bh_sess_data", "", time() - YEAR_IN_SECONDS);
    bh_setcookie("bh_sess_check", md5(uniqid(rand())), time() - YEAR_IN_SECONDS);

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