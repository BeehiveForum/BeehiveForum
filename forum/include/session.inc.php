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

/* $Id: session.inc.php,v 1.160 2005-03-05 21:09:55 decoyduck Exp $ */

include_once("./include/banned.inc.php");
include_once("./include/db.inc.php");
include_once("./include/format.inc.php");
include_once("./include/forum.inc.php");
include_once("./include/ip.inc.php");
include_once("./include/lang.inc.php");
include_once("./include/logon.inc.php");
include_once("./include/pm.inc.php");
include_once("./include/stats.inc.php");
include_once("./include/user.inc.php");

// Checks the session and returns it as an array.

function bh_session_check($show_session_fail = true)
{
    $db_bh_session_check = db_connect();
    $ipaddress = get_ip_address();

    $forum_settings = get_forum_settings();

    // Current server time.

    $current_time = time();

    // Session cut off timestamp

    $session_stamp = time() - intval(forum_get_setting('session_cutoff', false, 86400));

    // Check the current user's session data. This is the main session
    // data that Beehive relies on. If this data does not match what
    // we have stored in the database then the user gets logged out
    // automatically.

    if (isset($_COOKIE['bh_sess_hash']) && is_md5($_COOKIE['bh_sess_hash'])) {

        $user_hash = $_COOKIE['bh_sess_hash'];

        if ($table_data = get_table_prefix()) {

            $forum_fid = $table_data['FID'];

            $sql = "SELECT USER.LOGON, USER.NICKNAME, USER.EMAIL, USER.PASSWD, ";
            $sql.= "BIT_OR(GROUP_PERMS.PERM) AS STATUS, ";
            $sql.= "COUNT(GROUP_PERMS.GID) AS USER_PERM_COUNT, ";
            $sql.= "SESSIONS.UID, UNIX_TIMESTAMP(SESSIONS.TIME) AS TIME, ";
            $sql.= "SESSIONS.FID FROM SESSIONS SESSIONS ";
            $sql.= "LEFT JOIN USER USER ON (USER.UID = SESSIONS.UID) ";
            $sql.= "LEFT JOIN GROUP_USERS GROUP_USERS ON (GROUP_USERS.UID = SESSIONS.UID) ";
            $sql.= "LEFT JOIN GROUP_PERMS GROUP_PERMS ON (GROUP_PERMS.GID = GROUP_USERS.GID ";
            $sql.= "AND GROUP_PERMS.FID = 0 AND GROUP_PERMS.FORUM IN (0, $forum_fid)) ";
            $sql.= "WHERE SESSIONS.HASH = '$user_hash' ";
            $sql.= "GROUP BY USER.UID";

        }else {

            $forum_fid = 0;

            $sql = "SELECT USER.LOGON, USER.NICKNAME, USER.EMAIL, USER.PASSWD, ";
            $sql.= "BIT_OR(GROUP_PERMS.PERM) AS STATUS, ";
            $sql.= "COUNT(GROUP_PERMS.GID) AS USER_PERM_COUNT, ";
            $sql.= "SESSIONS.UID, UNIX_TIMESTAMP(SESSIONS.TIME) AS TIME, ";
            $sql.= "SESSIONS.FID FROM SESSIONS SESSIONS ";
            $sql.= "LEFT JOIN USER USER ON (USER.UID = SESSIONS.UID) ";
            $sql.= "LEFT JOIN GROUP_USERS GROUP_USERS ON (GROUP_USERS.UID = SESSIONS.UID) ";
            $sql.= "LEFT JOIN GROUP_PERMS GROUP_PERMS ON (GROUP_PERMS.GID = GROUP_USERS.GID ";
            $sql.= "AND GROUP_PERMS.FID = 0 AND GROUP_PERMS.FORUM IN (0)) ";
            $sql.= "WHERE SESSIONS.HASH = '$user_hash' ";
            $sql.= "GROUP BY USER.UID";
        }

        $result = db_query($sql, $db_bh_session_check);

        if (db_num_rows($result) > 0) {

            $user_sess = db_fetch_array($result);

            // check to see if the user's credentials match the
            // ban data set up on this forum.

            ban_check($user_sess);

            // Add preference settings

            $user_sess = array_merge($user_sess, user_get_prefs($user_sess['UID']));

            // We need to check here to see if the user is
            // banned from this forum as the login check
            // may have failed because they weren't logging
            // in to a specific forum.

            if (isset($user_sess['USER_PERM_COUNT']) && $user_sess['USER_PERM_COUNT'] > 0) {

                if (isset($user_sess['STATUS']) && $user_sess['STATUS'] & USER_PERM_BANNED) {

                    if (!strstr(php_sapi_name(), 'cgi')) {
                        header("HTTP/1.0 500 Internal Server Error");
                    }

                    echo "<h2>HTTP/1.0 500 Internal Server Error</h2>\n";
                    exit;
                }
            }

            // If the user isn't currently in the same forum
            // we should make it look like they've visited it.

            if ($user_sess['FID'] != $forum_fid) {

                bh_update_visitor_log($user_sess['UID']);
            }

            // Everything checks out OK. If the user's session is older
            // then 5 minutes we should update it.

            if (($current_time - $user_sess['TIME']) > 300) {

                $sql = "UPDATE SESSIONS SET TIME = NOW(), ";
                $sql.= "FID = '$forum_fid', IPADDRESS = '$ipaddress' ";
                $sql.= "WHERE HASH = '$user_hash'";

                $result = db_query($sql, $db_bh_session_check);

                if (forum_get_setting('show_stats', 'Y', false)) {
                    update_stats();
                }

                // Perform system-wide PM Prune

                pm_system_prune_folders();
            }

            // Delete expired sessions

            bh_remove_stale_sessions();

            return $user_sess;

        }elseif ($show_session_fail) {

            if (defined("BEEHIVEMODE_LIGHT")) {
                header_redirect("./llogon.php?final_uri=". get_request_uri());
            }

            html_draw_top();

            if (isset($_POST['user_logon']) && isset($_POST['user_password']) && isset($_POST['user_passhash'])) {

                if (perform_logon(false)) {

                    $lang = load_language_file();
                    $webtag = get_webtag($webtag_search);

                    echo "<h1>{$lang['loggedinsuccessfully']}</h1>";
                    echo "<div align=\"center\">\n";
                    echo "<p><b>{$lang['presscontinuetoresend']}</b></p>\n";

                    $request_uri = get_request_uri();

                    echo "<form method=\"post\" action=\"$request_uri\" target=\"_self\">\n";
                    echo form_input_hidden('webtag', $webtag);

                    foreach($_POST as $key => $value) {
                        echo form_input_hidden($key, _htmlentities(_stripslashes($value)));
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
    }

    if (user_guest_enabled() && !user_cookies_set()) {

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

        $sql = "SELECT * FROM SESSIONS WHERE UID = '0' ";
        $sql.= "AND IPADDRESS = '$ipaddress'";

        $result = db_query($sql, $db_bh_session_check);

        if (db_num_rows($result) > 0) {

            $user_sess = db_fetch_array($result);

            if (($current_time - $user_sess['TIME']) > 300) {

                $sql = "UPDATE SESSIONS SET TIME = NOW(), ";
                $sql.= "FID = '$fid' WHERE UID = 0 ";
                $sql.= "AND IPADDRESS = '$ipaddress'";

                $result = db_query($sql, $db_bh_session_check);
            }

        }else {

            $sql = "INSERT INTO SESSIONS (HASH, UID, FID, IPADDRESS, TIME) ";
            $sql.= "VALUES ('', 0, '$fid', '$ipaddress', NOW())";

            $result = db_query($sql, $db_bh_session_check);
        }

        bh_remove_stale_sessions();

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
                     'SHOW_STATS'       => 'Y',
                     'IMAGES_TO_LINKS'  => 'N',
                     'USE_WORD_FILTER'  => 'Y',
                     'USE_ADMIN_FILTER' => 'Y',
                     'POST_PAGE'        => 0,
                     'SHOW_THUMBS'      => '2');
    }

    // Delete expired sessions

    bh_remove_stale_sessions();

    return false;
}

// Fetches a value from the session

function bh_session_get_value($session_key)
{
    global $user_sess;

    if (isset($user_sess[$session_key])) return $user_sess[$session_key];
    if (strtoupper($session_key) == 'UID') return 0;

    return false;
}

// Delete expired sessions

function bh_remove_stale_sessions()
{
    $db_bh_remove_stale_sessions = db_connect();

    $session_stamp = time() - intval(forum_get_setting('session_cutoff', false, 86400));

    $sql = "DELETE FROM SESSIONS WHERE ";
    $sql.= "TIME < FROM_UNIXTIME($session_stamp)";

    $result = db_query($sql, $db_bh_remove_stale_sessions);

    return true;
}

// Updates the visitor log for the current user

function bh_update_visitor_log($uid)
{
    if (!is_numeric($uid)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $db_bh_update_visitor_log = db_connect();

    $user_prefs = user_get_prefs($uid);

    if (isset($user_prefs['ANON_LOGON']) && $user_prefs['ANON_LOGON'] == "Y") {

        $sql = "UPDATE {$table_data['PREFIX']}VISITOR_LOG ";
        $sql.= "SET LAST_LOGON = NULL WHERE UID = '$uid'";

    }else {

        $sql = "SELECT LAST_LOGON FROM {$table_data['PREFIX']}";
        $sql.= "VISITOR_LOG WHERE UID = '$uid'";

        $result = db_query($sql, $db_bh_update_visitor_log);

        if (db_num_rows($result) > 0) {

            $sql = "UPDATE {$table_data['PREFIX']}VISITOR_LOG ";
            $sql.= "SET LAST_LOGON = NOW() WHERE UID = '$uid'";

        }else {

            $sql = "INSERT INTO {$table_data['PREFIX']}VISITOR_LOG ";
            $sql.= "(UID, LAST_LOGON) VALUES ('$uid', NOW())";
        }
    }

    return db_query($sql, $db_bh_update_visitor_log);
}

// Initialises the session

function bh_session_init($uid, $update_visitor_log = true)
{
    $db_bh_session_init = db_connect();

    $ipaddress = get_ip_address();

    if ($table_data = get_table_prefix()) {
        $forum_fid = $table_data['FID'];
    }else {
        $forum_fid = 0;
    }

    $forum_settings = get_forum_settings();

    // Check to see if the user alredy hash a session
    // and reuse it if we can.

    $sql = "SELECT * FROM SESSIONS WHERE UID = '$uid' ";
    $sql.= "AND IPADDRESS = '$ipaddress'";

    $result = db_query($sql, $db_bh_session_init);

    if (db_num_rows($result) > 0) {

        $user_sess = db_fetch_array($result);

        if (isset($user_sess['HASH']) && is_md5($user_sess['HASH'])) {

            $user_hash = $user_sess['HASH'];

        }else {

            $user_hash = md5(uniqid($ipaddress));

            $sql = "UPDATE SESSIONS SET HASH = '$user_hash' ";
            $sql.= "WHERE UID = '$uid' AND IPADDRESS = '$ipaddress' ";
            $sql.= "AND FID = '$fid'";

            $result = db_query($sql, $db_bh_session_init);
        }

    }else {

        $user_hash = md5(uniqid($ipaddress));

        $sql = "INSERT INTO SESSIONS (HASH, UID, FID, IPADDRESS, TIME) ";
        $sql.= "VALUES ('$user_hash', '$uid', '$fid', ";
        $sql.= "'$ipaddress', NOW())";

        $result = db_query($sql, $db_bh_session_init);
    }

    if ($update_visitor_log) bh_update_visitor_log($uid);

    bh_setcookie('bh_sess_hash', $user_hash);
}

// Ends the session by deleting the session data and and the cookie hash.

function bh_session_end()
{
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

    if (substr($request_uri, -1) == '&') {
        $request_uri = substr($request_uri, 0, -1);
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

        $page_prefs = POST_TOOLBAR_DISPLAY | POST_EMOTICONS_DISPLAY | POST_TEXT_DEFAULT | POST_AUTO_LINKS | POST_SIGNATURE_DISPLAY;
    }

    return $page_prefs;
}

?>