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

/* $Id: banned.inc.php,v 1.30 2007-12-26 17:44:35 decoyduck Exp $ */

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

// banned.inc.php contains functions for checking the ban data
// against the user credentials.

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "ip.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

function ban_check($user_sess, $user_is_guest = false)
{
    if (!$db_ban_check = db_connect()) return false;

    if (!is_array($user_sess)) return false;
    if (!is_bool($user_is_guest)) $user_is_guest = false;

    if (!$table_data = get_table_prefix()) return false;

    $ban_type_ip    = BAN_TYPE_IP;
    $ban_type_logon = BAN_TYPE_LOGON;
    $ban_type_nick  = BAN_TYPE_NICK;
    $ban_type_email = BAN_TYPE_EMAIL;
    $ban_type_ref   = BAN_TYPE_REF;

    $ban_check_array = array();

    if ($ipaddress = get_ip_address()) {

        $ipaddress = db_escape_string($ipaddress);
        $ban_check_array[] = "('$ipaddress' LIKE BANDATA AND BANTYPE = $ban_type_ip)";
    }

    if (isset($user_sess['REFERER']) && strlen(trim($user_sess['REFERER'])) > 0) {

        $referer = db_escape_string($user_sess['REFERER']);
        $ban_check_array[] = "('$referer' LIKE BANDATA AND BANTYPE = $ban_type_ref)";
    }

    if ($user_is_guest === false) {

        if (isset($user_sess['LOGON']) && strlen(trim($user_sess['LOGON'])) > 0) {

            $logon = db_escape_string($user_sess['LOGON']);
            $ban_check_array[] = "('$logon' LIKE BANDATA AND BANTYPE = $ban_type_logon)";
        }

        if (isset($user_sess['NICKNAME']) && strlen(trim($user_sess['NICKNAME'])) > 0) {

            $nickname = db_escape_string($user_sess['NICKNAME']);
            $ban_check_array[] = "('$nickname' LIKE BANDATA AND BANTYPE = $ban_type_nick)";
        }

        if (isset($user_sess['EMAIL']) && strlen(trim($user_sess['EMAIL'])) > 0) {

            $email = db_escape_string($user_sess['EMAIL']);
            $ban_check_array[] = "('$email' LIKE BANDATA AND BANTYPE = $ban_type_email)";
        }
    }

    $ban_check_query = implode(" OR ", $ban_check_array);

    if (defined("BEEHIVE_INSTALL_NOWARN")) return true;

    if (strlen(trim($ban_check_query)) > 0) {

        $sql = "SELECT COUNT(ID) FROM {$table_data['PREFIX']}BANNED ";
        $sql.= "WHERE $ban_check_query";

        if (!$result = db_query($sql, $db_ban_check)) return false;

        list($ban_count) = db_fetch_array($result, DB_RESULT_NUM);

        if ($ban_count > 0) {

            header_server_error();
            exit;
        }
    }

    return true;
}

function ip_is_banned($ipaddress)
{
    if (!$db_ip_is_banned = db_connect()) return false;

    $ipaddress = db_escape_string($ipaddress);

    if (!$table_data = get_table_prefix()) return false;

    $ban_type_ip = BAN_TYPE_IP;

    $sql = "SELECT ID FROM {$table_data['PREFIX']}BANNED ";
    $sql.= "WHERE '$ipaddress' LIKE BANDATA ";
    $sql.= "AND BANTYPE = '$ban_type_ip' ";
    $sql.= "LIMIT 0, 1";

    if (!$result = db_query($sql, $db_ip_is_banned)) return false;

    return (db_num_rows($result) > 0);
}

function logon_is_banned($logon)
{
    if (!$db_logon_is_banned = db_connect()) return false;

    $logon = db_escape_string($logon);

    if (!$table_data = get_table_prefix()) return false;

    $ban_type_logon = BAN_TYPE_LOGON;

    $sql = "SELECT ID FROM {$table_data['PREFIX']}BANNED ";
    $sql.= "WHERE '$logon' LIKE BANDATA ";
    $sql.= "AND BANTYPE = '$ban_type_logon' ";
    $sql.= "LIMIT 0, 1";

    if (!$result = db_query($sql, $db_logon_is_banned)) return false;

    return (db_num_rows($result) > 0);
}

function nickname_is_banned($nickname)
{
    if (!$db_nickname_is_banned = db_connect()) return false;

    $nickname = db_escape_string($nickname);

    if (!$table_data = get_table_prefix()) return false;

    $ban_type_nick = BAN_TYPE_NICK;

    $sql = "SELECT ID FROM {$table_data['PREFIX']}BANNED ";
    $sql.= "WHERE '$nickname' LIKE BANDATA ";
    $sql.= "AND BANTYPE = '$ban_type_nick' ";
    $sql.= "LIMIT 0, 1";

    if (!$result = db_query($sql, $db_nickname_is_banned)) return false;

    return (db_num_rows($result) > 0);
}

function email_is_banned($email)
{
    if (!$db_email_is_banned = db_connect()) return false;

    $email = db_escape_string($email);

    if (!$table_data = get_table_prefix()) return false;

    $ban_type_email = BAN_TYPE_EMAIL;

    $sql = "SELECT ID FROM {$table_data['PREFIX']}BANNED ";
    $sql.= "WHERE '$email' LIKE BANDATA ";
    $sql.= "AND BANTYPE = '$ban_type_email' ";
    $sql.= "LIMIT 0, 1";

    if (!$result = db_query($sql, $db_email_is_banned)) return false;

    return (db_num_rows($result) > 0);
}

function referer_is_banned($referer)
{
    if (!$db_referer_is_banned = db_connect()) return false;

    $referer = db_escape_string($referer);

    if (!$table_data = get_table_prefix()) return false;

    $ban_type_ref = BAN_TYPE_REF;

    $sql = "SELECT ID FROM {$table_data['PREFIX']}BANNED ";
    $sql.= "WHERE '$referer' LIKE BANDATA ";
    $sql.= "AND BANTYPE = '$ban_type_ref' ";
    $sql.= "LIMIT 0, 1";

    if (!$result = db_query($sql, $db_referer_is_banned)) return false;

    return (db_num_rows($result) > 0);
}

function add_ban_data($type, $data, $comment)
{
    if (!$db_add_ban_data = db_connect()) return false;

    $data_types_array = array(BAN_TYPE_IP, BAN_TYPE_LOGON, BAN_TYPE_NICK, BAN_TYPE_EMAIL, BAN_TYPE_REF);

    if (!in_array($type, $data_types_array)) return false;

    $data = db_escape_string($data);
    $comment = db_escape_string($comment);

    if (!$table_data = get_table_prefix()) return false;

    $sql = "INSERT INTO {$table_data['PREFIX']}BANNED (BANTYPE, BANDATA, COMMENT) ";
    $sql.= "VALUES ('$type', '$data', '$comment')";

    if (!$result = db_query($sql, $db_add_ban_data)) return false;

    return true;
}

function remove_ban_data_by_id($ban_id)
{
    if (!$db_remove_ban_data = db_connect()) return false;

    if (!is_numeric($ban_id)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "DELETE QUICK FROM {$table_data['PREFIX']}BANNED ";
    $sql.= "WHERE ID = '$ban_id'";

    if (!$result = db_query($sql, $db_remove_ban_data)) return false;

    return (db_affected_rows($db_remove_ban_data) > 0);
}

function update_ban_data($ban_id, $type, $data, $comment)
{
    if (!$db_remove_ban_data = db_connect()) return false;

    if (!is_numeric($ban_id)) return false;

    $data_types_array = array(BAN_TYPE_IP, BAN_TYPE_LOGON, BAN_TYPE_NICK, BAN_TYPE_EMAIL, BAN_TYPE_REF);

    if (!in_array($type, $data_types_array)) return false;

    $data = db_escape_string($data);
    $comment = db_escape_string($comment);

    if (!$table_data = get_table_prefix()) return false;

    $sql = "UPDATE LOW_PRIORITY {$table_data['PREFIX']}BANNED ";
    $sql.= "SET BANTYPE = '$type', BANDATA = '$data', ";
    $sql.= "COMMENT = '$comment' WHERE ID = '$ban_id'";

    if (!$result = db_query($sql, $db_remove_ban_data)) return false;

    return true;
}

function check_ban_data($ban_type, $ban_data, $check_ban_id = false)
{
    if (!$db_referer_is_banned = db_connect()) return false;

    if (!is_numeric($ban_type)) return false;
    if (!is_numeric($check_ban_id)) $ban_id = false;

    $ban_data = db_escape_string($ban_data);

    if (!$table_data = get_table_prefix()) return false;

    if (is_numeric($check_ban_id)) {

        $sql = "SELECT ID FROM {$table_data['PREFIX']}BANNED ";
        $sql.= "WHERE '$ban_data' LIKE BANDATA AND BANTYPE = '$ban_type' ";
        $sql.= "AND ID <> '$check_ban_id' LIMIT 0, 1";

    }else {

        $sql = "SELECT ID FROM {$table_data['PREFIX']}BANNED ";
        $sql.= "WHERE '$ban_data' LIKE BANDATA AND BANTYPE = '$ban_type' ";
        $sql.= "LIMIT 0, 1";
    }

    if (!$result = db_query($sql, $db_referer_is_banned)) return false;

    if (db_num_rows($result) > 0) {

        list($ban_id) = db_fetch_array($result, DB_RESULT_NUM);
        return $ban_id;
    }

    return false;
}

function check_affected_sessions($ban_type, $ban_data)
{
    if (!$db_check_affected_sessions = db_connect()) return false;

    $lang = load_language_file();

    if (!is_numeric($ban_type)) return false;

    $ban_data = db_escape_string($ban_data);

    $affected_sessions = array();

    $ban_type_ip    = BAN_TYPE_IP;
    $ban_type_logon = BAN_TYPE_LOGON;
    $ban_type_nick  = BAN_TYPE_NICK;
    $ban_type_email = BAN_TYPE_EMAIL;
    $ban_type_ref   = BAN_TYPE_REF;

    if (!$table_data = get_table_prefix()) return false;

    if (($uid = bh_session_get_value('UID')) === false) return false;

    $sql = "SELECT DISTINCT SESSIONS.UID, USER.LOGON, ";
    $sql.= "USER_PEER.PEER_NICKNAME, USER.NICKNAME FROM SESSIONS ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = SESSIONS.UID) ";
    $sql.= "LEFT JOIN {$table_data['PREFIX']}USER_PEER USER_PEER ";
    $sql.= "ON (USER_PEER.PEER_UID = SESSIONS.UID AND USER_PEER.UID = '$uid') ";
    $sql.= "WHERE SESSIONS.UID > 0 AND (((SESSIONS.IPADDRESS LIKE '$ban_data' ";
    $sql.= "OR USER.IPADDRESS LIKE '$ban_data') AND '$ban_type' = '$ban_type_ip') ";
    $sql.= "OR ((SESSIONS.REFERER LIKE '$ban_data' OR USER.REFERER LIKE '$ban_data') ";
    $sql.= "AND '$ban_type' = '$ban_type_ref') OR (USER.LOGON LIKE '$ban_data' ";
    $sql.= "AND '$ban_type' = '$ban_type_logon') OR (USER.NICKNAME LIKE '$ban_data' ";
    $sql.= "AND '$ban_type' = '$ban_type_nick') OR (USER.EMAIL LIKE '$ban_data' ";
    $sql.= "AND '$ban_type' = '$ban_type_email'))";

    if (!$result = db_query($sql, $db_check_affected_sessions)) return false;

    if (db_num_rows($result) > 0) {

        while ($user_session = db_fetch_array($result)) {

            if (isset($user_session['LOGON']) && isset($user_session['PEER_NICKNAME'])) {
                if (!is_null($user_session['PEER_NICKNAME']) && strlen($user_session['PEER_NICKNAME']) > 0) {
                    $user_session['NICKNAME'] = $user_session['PEER_NICKNAME'];
                }
            }

            if (!isset($user_session['LOGON'])) $user_session['LOGON'] = $lang['unknownuser'];
            if (!isset($user_session['NICKNAME'])) $user_session['NICKNAME'] = "";

            $affected_sessions[$user_session['UID']] = $user_session;
        }
    }

    $sql = "SELECT COUNT(SESSIONS.UID) FROM SESSIONS WHERE SESSIONS.UID = 0 ";
    $sql.= "AND (('$ban_data' LIKE SESSIONS.IPADDRESS AND '$ban_type' = '$ban_type_ip') ";
    $sql.= "OR (SESSIONS.REFERER LIKE '$ban_data' AND '$ban_type' = '$ban_type_ref'))";

    if (!$result = db_query($sql, $db_check_affected_sessions)) return false;

    list($affected_guest_count) = db_fetch_array($result, DB_RESULT_NUM);

    for ($i = 0; $i < $affected_guest_count; $i++) {

        $affected_sessions[] = array('UID' => 0, 'LOGON' => 'GUEST', 'NICKNAME' => 'GUEST');
    }

    return (sizeof($affected_sessions) > 0) ? $affected_sessions : false;
}

?>