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

/* $Id$ */

// We shouldn't be accessing this file directly.

if (basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

// banned.inc.php contains functions for checking the ban data
// against the user credentials.

include_once(BH_INCLUDE_PATH. "admin.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "header.inc.php");
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

    $admin_log_types_array = array(BAN_TYPE_IP    => BAN_HIT_TYPE_IP,
                                   BAN_TYPE_LOGON => BAN_HIT_TYPE_LOGON,
                                   BAN_TYPE_NICK  => BAN_HIT_TYPE_NICK,
                                   BAN_TYPE_EMAIL => BAN_HIT_TYPE_EMAIL,
                                   BAN_TYPE_REF   => BAN_HIT_TYPE_REF);

    $ban_check_select_array = array();
    $ban_check_where_array  = array();

    if (($ipaddress = get_ip_address())) {

        $ipaddress = db_escape_string($ipaddress);

        $ban_check_select_array[] = "'$ipaddress' AS IPADDRESS";
        $ban_check_where_array[]  = "('$ipaddress' LIKE BANDATA AND BANTYPE = $ban_type_ip)";
    }

    if (isset($user_sess['REFERER']) && strlen(trim($user_sess['REFERER'])) > 0) {

        $referer = db_escape_string($user_sess['REFERER']);

        $ban_check_select_array[] = "'$referer' AS REFERER";
        $ban_check_where_array[]  = "('$referer' LIKE BANDATA AND BANTYPE = $ban_type_ref)";
    }

    if ($user_is_guest === false) {

        if (isset($user_sess['LOGON']) && strlen(trim($user_sess['LOGON'])) > 0) {

            $logon = db_escape_string($user_sess['LOGON']);

            $ban_check_select_array[] = "'$logon' AS LOGON";
            $ban_check_where_array[] = "('$logon' LIKE BANDATA AND BANTYPE = $ban_type_logon)";
        }

        if (isset($user_sess['NICKNAME']) && strlen(trim($user_sess['NICKNAME'])) > 0) {

            $nickname = db_escape_string($user_sess['NICKNAME']);

            $ban_check_select_array[] = "'$nickname' AS NICKNAME";
            $ban_check_where_array[]  = "('$nickname' LIKE BANDATA AND BANTYPE = $ban_type_nick)";
        }

        if (isset($user_sess['EMAIL']) && strlen(trim($user_sess['EMAIL'])) > 0) {

            $email = db_escape_string($user_sess['EMAIL']);

            $ban_check_select_array[] = "'$email' AS EMAIL";
            $ban_check_where_array[]  = "('$email' LIKE BANDATA AND BANTYPE = $ban_type_email)";
        }
    }

    $ban_check_select_list = implode(", ", $ban_check_select_array);
    $ban_check_where_query = implode(" OR ", $ban_check_where_array);

    if (strlen(trim($ban_check_where_query)) > 0 && strlen(trim($ban_check_select_list)) > 0) {
    
        $current_datetime = date(MYSQL_DATETIME_MIDNIGHT, time());

        $sql = "SELECT ID, BANTYPE, BANDATA, $ban_check_select_list ";
        $sql.= "FROM `{$table_data['PREFIX']}BANNED` WHERE $ban_check_where_query ";
        $sql.= "AND (EXPIRES > CAST('$current_datetime' AS DATETIME) OR EXPIRES = 0)";

        if (!$result = db_query($sql, $db_ban_check)) return false;

        if (db_num_rows($result) > 0) {

            while (($ban_check_result_array = db_fetch_array($result))) {

                if (isset($ban_check_result_array['BANTYPE']) && is_numeric($ban_check_result_array['BANTYPE'])) {

                    $ban_check_type = $ban_check_result_array['BANTYPE'];

                    if (($ban_check_data = ban_check_process_data($ban_check_result_array))) {

                        if ($user_is_guest === false) {
                            array_push($ban_check_data, $user_sess['UID'], $user_sess['LOGON']);
                        }

                        admin_add_log_entry($admin_log_types_array[$ban_check_type], $ban_check_data);
                    }
                }
            }

            if (defined("BEEHIVE_INSTALL_NOWARN")) return true;

            header_server_error();
            exit;
        }
    }

    return true;
}

function ban_check_process_data($ban_result)
{
    if (!is_array($ban_result)) return false;

    if (!isset($ban_result['BANTYPE'])) return false;
    if (!isset($ban_result['BANDATA'])) return false;

    if (!is_numeric($ban_result['BANTYPE'])) return false;

    switch ($ban_result['BANTYPE']) {

        case BAN_TYPE_IP:

            return (isset($ban_result['IPADDRESS'])) ? array($ban_result['ID'], $ban_result['IPADDRESS'], $ban_result['BANDATA']) : false;
            break;

        case BAN_TYPE_LOGON:

            return (isset($ban_result['LOGON'])) ? array($ban_result['ID'], $ban_result['LOGON'], $ban_result['BANDATA']) : false;
            break;

        case BAN_TYPE_NICK:

            return (isset($ban_result['NICKNAME'])) ? array($ban_result['ID'], $ban_result['NICKNAME'], $ban_result['BANDATA']) : false;
            break;

        case BAN_TYPE_EMAIL:

            return (isset($ban_result['EMAIL'])) ? array($ban_result['ID'], $ban_result['EMAIL'], $ban_result['BANDATA']) : false;
            break;

        case BAN_TYPE_REF:

            return (isset($ban_result['REFERER'])) ? array($ban_result['ID'], $ban_result['REFERER'], $ban_result['BANDATA']) : false;
            break;
    }

    return false;
}

function ip_is_banned($ipaddress)
{
    if (!$db_ip_is_banned = db_connect()) return false;

    $ipaddress = db_escape_string($ipaddress);

    if (!$table_data = get_table_prefix()) return false;

    $ban_type_ip = BAN_TYPE_IP;
    
    $current_datetime = date(MYSQL_DATETIME_MIDNIGHT, time());

    $sql = "SELECT COUNT(ID) FROM `{$table_data['PREFIX']}BANNED` ";
    $sql.= "WHERE '$ipaddress' LIKE BANDATA  AND BANTYPE = '$ban_type_ip' ";
    $sql.= "AND (EXPIRES > CAST('$current_datetime' AS DATETIME) OR EXPIRES = 0)";

    if (!$result = db_query($sql, $db_ip_is_banned)) return false;
    
    list($ban_count) = db_fetch_array($result, DB_RESULT_NUM);

    return ($ban_count > 0);
}

function logon_is_banned($logon)
{
    if (!$db_logon_is_banned = db_connect()) return false;

    $logon = db_escape_string($logon);

    if (!$table_data = get_table_prefix()) return false;

    $ban_type_logon = BAN_TYPE_LOGON;
    
    $current_datetime = date(MYSQL_DATETIME_MIDNIGHT, time());

    $sql = "SELECT COUNT(ID) FROM `{$table_data['PREFIX']}BANNED` ";
    $sql.= "WHERE '$logon' LIKE BANDATA AND BANTYPE = '$ban_type_logon' ";
    $sql.= "AND (EXPIRES > CAST('$current_datetime' AS DATETIME) OR EXPIRES = 0)";

    if (!$result = db_query($sql, $db_logon_is_banned)) return false;

    list($ban_count) = db_fetch_array($result, DB_RESULT_NUM);

    return ($ban_count > 0);
}

function nickname_is_banned($nickname)
{
    if (!$db_nickname_is_banned = db_connect()) return false;

    $nickname = db_escape_string($nickname);

    if (!$table_data = get_table_prefix()) return false;

    $ban_type_nick = BAN_TYPE_NICK;
    
    $current_datetime = date(MYSQL_DATETIME_MIDNIGHT, time());

    $sql = "SELECT COUNT(ID) FROM `{$table_data['PREFIX']}BANNED` ";
    $sql.= "WHERE '$nickname' LIKE BANDATA AND BANTYPE = '$ban_type_nick' ";
    $sql.= "AND (EXPIRES > CAST('$current_datetime' AS DATETIME) OR EXPIRES = 0)";

    if (!$result = db_query($sql, $db_nickname_is_banned)) return false;

    list($ban_count) = db_fetch_array($result, DB_RESULT_NUM);

    return ($ban_count > 0);
}

function email_is_banned($email)
{
    if (!$db_email_is_banned = db_connect()) return false;

    $email = db_escape_string($email);

    if (!$table_data = get_table_prefix()) return false;

    $ban_type_email = BAN_TYPE_EMAIL;
    
    $current_datetime = date(MYSQL_DATETIME_MIDNIGHT, time());

    $sql = "SELECT COUNT(ID) FROM `{$table_data['PREFIX']}BANNED` ";
    $sql.= "WHERE '$email' LIKE BANDATA AND BANTYPE = '$ban_type_email' ";
    $sql.= "AND (EXPIRES > CAST('$current_datetime' AS DATETIME) OR EXPIRES = 0)";

    if (!$result = db_query($sql, $db_email_is_banned)) return false;

    list($ban_count) = db_fetch_array($result, DB_RESULT_NUM);

    return ($ban_count > 0);
}

function referer_is_banned($referer)
{
    if (!$db_referer_is_banned = db_connect()) return false;

    $referer = db_escape_string($referer);

    if (!$table_data = get_table_prefix()) return false;

    $ban_type_ref = BAN_TYPE_REF;
    
    $current_datetime = date(MYSQL_DATETIME_MIDNIGHT, time());

    $sql = "SELECT COUNT(ID) FROM `{$table_data['PREFIX']}BANNED` ";
    $sql.= "WHERE '$referer' LIKE BANDATA AND BANTYPE = '$ban_type_ref' ";
    $sql.= "AND (EXPIRES > CAST('$current_datetime' AS DATETIME) OR EXPIRES = 0)";

    if (!$result = db_query($sql, $db_referer_is_banned)) return false;

    list($ban_count) = db_fetch_array($result, DB_RESULT_NUM);

    return ($ban_count > 0);
}

function add_ban_data($type, $data, $comment, $expires)
{
    if (!$db_add_ban_data = db_connect()) return false;

    $data_types_array = array(BAN_TYPE_IP, BAN_TYPE_LOGON, BAN_TYPE_NICK, BAN_TYPE_EMAIL, BAN_TYPE_REF);

    if (!in_array($type, $data_types_array)) return false;

    $data = db_escape_string($data);
    $comment = db_escape_string($comment);
    
    if (!$table_data = get_table_prefix()) return false;
    
    if (is_numeric($expires) && $expires > 0) {
        
        $expires_datetime = date(MYSQL_DATETIME_MIDNIGHT, $expires);

        $sql = "INSERT INTO `{$table_data['PREFIX']}BANNED` (BANTYPE, BANDATA, COMMENT, EXPIRES) ";
        $sql.= "VALUES ('$type', '$data', '$comment', CAST('$expires_datetime' AS DATETIME))";
        
    }else {
    
        $sql = "INSERT INTO `{$table_data['PREFIX']}BANNED` (BANTYPE, BANDATA, COMMENT, EXPIRES) ";
        $sql.= "VALUES ('$type', '$data', '$comment', 0)";
    }

    if (!db_query($sql, $db_add_ban_data)) return false;

    return true;
}

function remove_ban_data_by_id($ban_id)
{
    if (!$db_remove_ban_data = db_connect()) return false;

    if (!is_numeric($ban_id)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "DELETE QUICK FROM `{$table_data['PREFIX']}BANNED` ";
    $sql.= "WHERE ID = '$ban_id'";

    if (!db_query($sql, $db_remove_ban_data)) return false;

    return (db_affected_rows($db_remove_ban_data) > 0);
}

function update_ban_data($ban_id, $type, $data, $comment, $expires)
{
    if (!$db_remove_ban_data = db_connect()) return false;

    if (!is_numeric($ban_id)) return false;

    $data_types_array = array(BAN_TYPE_IP, BAN_TYPE_LOGON, BAN_TYPE_NICK, BAN_TYPE_EMAIL, BAN_TYPE_REF);

    if (!in_array($type, $data_types_array)) return false;

    $data = db_escape_string($data);
    $comment = db_escape_string($comment);

    if (!$table_data = get_table_prefix()) return false;

    if (is_numeric($expires) && $expires > 0) {
    
        $expires_datetime = date(MYSQL_DATETIME_MIDNIGHT, $expires);

        $sql = "UPDATE LOW_PRIORITY `{$table_data['PREFIX']}BANNED` ";
        $sql.= "SET BANTYPE = '$type', BANDATA = '$data', COMMENT = '$comment', ";
        $sql.= "EXPIRES = CAST('$expires_datetime' AS DATETIME) ";
        $sql.= "WHERE ID = '$ban_id'";

    }else {

        $sql = "UPDATE LOW_PRIORITY `{$table_data['PREFIX']}BANNED` ";
        $sql.= "SET BANTYPE = '$type', BANDATA = '$data', COMMENT = '$comment', ";
        $sql.= "EXPIRES = 0 WHERE ID = '$ban_id'";
    }

    if (!db_query($sql, $db_remove_ban_data)) return false;

    return true;
}

function check_ban_data($ban_type, $ban_data, $ban_expires = 0)
{
    if (!$db_referer_is_banned = db_connect()) return false;

    if (!is_numeric($ban_type)) return false;
    if (!is_numeric($ban_expires)) return false;

    $ban_data = db_escape_string($ban_data);

    if (!$table_data = get_table_prefix()) return false;
    
    $current_datetime = time();

    $sql = "SELECT ID FROM `{$table_data['PREFIX']}BANNED` ";
    $sql.= "WHERE '$ban_data' LIKE BANDATA AND BANTYPE = '$ban_type' ";
    $sql.= "AND ($ban_expires > $current_datetime OR $ban_expires = 0) ";
    $sql.= "LIMIT 0, 1";

    if (!$result = db_query($sql, $db_referer_is_banned)) return false;

    if (db_num_rows($result) > 0) {

        list($ban_id) = db_fetch_array($result, DB_RESULT_NUM);
        return $ban_id;
    }

    return false;
}

function check_affected_sessions($ban_type, $ban_data, $ban_expires)
{
    if (!$db_check_affected_sessions = db_connect()) return false;

    $lang = load_language_file();

    if (!is_numeric($ban_type)) return false;
    if (!is_numeric($ban_expires)) return false;

    $ban_data = db_escape_string($ban_data);

    $affected_sessions = array();

    $ban_type_ip    = BAN_TYPE_IP;
    $ban_type_logon = BAN_TYPE_LOGON;
    $ban_type_nick  = BAN_TYPE_NICK;
    $ban_type_email = BAN_TYPE_EMAIL;
    $ban_type_ref   = BAN_TYPE_REF;

    if (!$table_data = get_table_prefix()) return false;

    if (($uid = bh_session_get_value('UID')) === false) return false;
    
    $current_datetime = time();

    $sql = "SELECT DISTINCT SESSIONS.UID, USER.LOGON, ";
    $sql.= "USER_PEER.PEER_NICKNAME, USER.NICKNAME FROM SESSIONS ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = SESSIONS.UID) ";
    $sql.= "LEFT JOIN `{$table_data['PREFIX']}USER_PEER` USER_PEER ";
    $sql.= "ON (USER_PEER.PEER_UID = SESSIONS.UID AND USER_PEER.UID = '$uid') ";
    $sql.= "WHERE ($ban_expires > $current_datetime OR $ban_expires = 0) ";    
    $sql.= "AND SESSIONS.UID > 0 AND (((SESSIONS.IPADDRESS LIKE '$ban_data' ";
    $sql.= "OR USER.IPADDRESS LIKE '$ban_data') AND '$ban_type' = '$ban_type_ip') ";
    $sql.= "OR ((SESSIONS.REFERER LIKE '$ban_data' OR USER.REFERER LIKE '$ban_data') ";
    $sql.= "AND '$ban_type' = '$ban_type_ref') OR (USER.LOGON LIKE '$ban_data' ";
    $sql.= "AND '$ban_type' = '$ban_type_logon') OR (USER.NICKNAME LIKE '$ban_data' ";
    $sql.= "AND '$ban_type' = '$ban_type_nick') OR (USER.EMAIL LIKE '$ban_data' ";
    $sql.= "AND '$ban_type' = '$ban_type_email'))";

    if (!$result = db_query($sql, $db_check_affected_sessions)) return false;

    if (db_num_rows($result) > 0) {

        while (($user_session = db_fetch_array($result))) {

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
    $sql.= "OR (SESSIONS.REFERER LIKE '$ban_data' AND '$ban_type' = '$ban_type_ref')) ";
    $sql.= "AND ($ban_expires > CAST('$current_datetime' AS DATETIME) OR $ban_expires = 0)";

    if (!$result = db_query($sql, $db_check_affected_sessions)) return false;

    list($affected_guest_count) = db_fetch_array($result, DB_RESULT_NUM);

    for ($i = 0; $i < $affected_guest_count; $i++) {

        $affected_sessions[] = array('UID' => 0, 'LOGON' => 'GUEST', 'NICKNAME' => 'GUEST');
    }

    return (sizeof($affected_sessions) > 0) ? $affected_sessions : false;
}

function user_is_banned($uid)
{
    if (!$db_user_is_banned = db_connect()) return false;

    if (!is_numeric($uid)) return false;

    $ban_type_ip    = BAN_TYPE_IP;
    $ban_type_logon = BAN_TYPE_LOGON;
    $ban_type_nick  = BAN_TYPE_NICK;
    $ban_type_email = BAN_TYPE_EMAIL;
    $ban_type_ref   = BAN_TYPE_REF;

    if (!$table_data = get_table_prefix()) return false;
    
    $current_datetime = date(MYSQL_DATETIME_MIDNIGHT, time());

    $sql = "SELECT COUNT(BANNED.ID) AS BAN_COUNT FROM `{$table_data['PREFIX']}BANNED` BANNED, ";
    $sql.= "USER USER LEFT JOIN SESSIONS SESSIONS ON (USER.UID = SESSIONS.UID) ";
    $sql.= "WHERE ((SESSIONS.IPADDRESS LIKE BANNED.BANDATA AND BANNED.BANTYPE = '$ban_type_ip') ";
    $sql.= "OR (SESSIONS.REFERER LIKE BANNED.BANDATA AND BANNED.BANTYPE = '$ban_type_ref') ";
    $sql.= "OR (USER.IPADDRESS LIKE BANNED.BANDATA AND BANNED.BANTYPE = '$ban_type_ip') ";
    $sql.= "OR (USER.LOGON LIKE BANNED.BANDATA AND BANNED.BANTYPE = '$ban_type_logon') ";
    $sql.= "OR (USER.NICKNAME LIKE BANNED.BANDATA AND BANNED.BANTYPE = '$ban_type_nick') ";
    $sql.= "OR (USER.EMAIL LIKE BANNED.BANDATA AND BANNED.BANTYPE = '$ban_type_email') ";
    $sql.= "OR (USER.REFERER LIKE BANNED.BANDATA AND BANNED.BANTYPE = '$ban_type_ref')) ";
    $sql.= "AND (EXPIRES > CAST('$current_datetime' AS DATETIME) OR EXPIRES = 0) ";
    $sql.= "AND USER.UID = '$uid'";

    if (!$result = db_query($sql, $db_user_is_banned)) return false;

    list($ban_count) = db_fetch_array($result, DB_RESULT_NUM);

    return $ban_count > 0;
}

?>