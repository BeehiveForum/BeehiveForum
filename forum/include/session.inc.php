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

/* $Id: session.inc.php,v 1.40 2003-08-05 03:11:21 decoyduck Exp $ */

require_once("./include/forum.inc.php");
require_once("./include/config.inc.php");
require_once("./include/user.inc.php");
require_once("./include/format.inc.php");
require_once("./include/ip.inc.php");

// Checks the session

function bh_session_check()
{
    ip_check();

    global $HTTP_COOKIE_VARS;

    if (isset($HTTP_COOKIE_VARS['bh_sess_data']) && isset($HTTP_COOKIE_VARS['bh_sess_check'])) {

        $user_sess = _stripslashes($HTTP_COOKIE_VARS['bh_sess_data']);
        $user_hash = $HTTP_COOKIE_VARS['bh_sess_check'];

        if (md5($user_sess) == $user_hash) {
            $user_sess = unserialize(_stripslashes($HTTP_COOKIE_VARS['bh_sess_data']));
            if (user_check_logon($user_sess['UID'], $user_sess['LOGON'], $user_sess['PASSWD'])) {
                return true;
            }
        }
    }

    return false;

}

// Fetches a value from the session

function bh_session_get_value($session_key)
{
    global $HTTP_COOKIE_VARS;

    if (bh_session_check()) {
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

    $sql = "select USER.UID, USER.LOGON, USER.PASSWD, USER.STATUS, USER_PREFS.POSTS_PER_PAGE, USER_PREFS.TIMEZONE, ";
    $sql.= "USER_PREFS.DL_SAVING, USER_PREFS.MARK_AS_OF_INT, USER_PREFS.FONT_SIZE, USER_PREFS.STYLE, ";
    $sql.= "USER_PREFS.VIEW_SIGS, USER_PREFS.START_PAGE, USER_PREFS.LANGUAGE, USER_PREFS.PM_NOTIFY ";
    $sql.= "from " . forum_table("USER") . " USER left join " . forum_table("USER_PREFS") . " USER_PREFS on (USER.UID = USER_PREFS.UID) ";
    $sql.= "where USER.UID = $uid";

    $db_bh_session_init = db_connect();
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
                           'PM_NOTIFY'      => 'N');

    }

    $check = md5(serialize($user_sess));

    setcookie("bh_sess_data", serialize($user_sess));
    setcookie("bh_sess_check", $check);

}

// Ends the session by deleting the cookie data and scrambling the MD5 check.

function bh_session_end()
{
    // Session cookies

    setcookie("bh_sess_data", "", time() - 3600);
    setcookie("bh_sess_check", md5(uniqid(rand())), time() - 3600);

    // Other cookies set by Beehive

    setcookie("bh_thread_mode", "", time() - 3600);

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