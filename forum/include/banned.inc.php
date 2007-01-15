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

/* $Id: banned.inc.php,v 1.17 2007-01-15 00:10:35 decoyduck Exp $ */

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

// banned.inc.php contains functions for checking the ban data
// against the user credentials.

include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "ip.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

function ban_check($user_sess, $user_is_guest = false)
{
    $db_ban_check = db_connect();

    if (!is_array($user_sess)) return false;
    if (!is_bool($user_is_guest)) $user_is_guest = false;

    if (!$table_data = get_table_prefix()) return false;

    $ban_check_array = array();

    if ($ipaddress = get_ip_address()) {

        $ipaddress = addslashes($ipaddress);
        $ban_check_array[] = "('$ipaddress' LIKE BANDATA AND BANTYPE = 1)";
    }

    if (isset($user_sess['REFERER']) && strlen(trim($user_sess['REFERER'])) > 0) {

        $referer = addslashes($user_sess['REFERER']);
        $ban_check_array[] = "('$referer' LIKE BANDATA AND BANTYPE = 5)";
    }

    if ($user_is_guest === false) {

        if (isset($user_sess['LOGON']) && strlen(trim($user_sess['LOGON'])) > 0) {
            
            $logon = addslashes($user_sess['LOGON']);
            $ban_check_array[] = "('$logon' LIKE BANDATA AND BANTYPE = 2)";
        }

        if (isset($user_sess['NICKNAME']) && strlen(trim($user_sess['NICKNAME'])) > 0) {
            
            $nickname = addslashes($user_sess['NICKNAME']);
            $ban_check_array[] = "('$nickname' LIKE BANDATA AND BANTYPE = 3)";
        }

        if (isset($user_sess['EMAIL']) && strlen(trim($user_sess['EMAIL'])) > 0) {
            
            $email = addslashes($user_sess['EMAIL']);
            $ban_check_array[] = "('$email' LIKE BANDATA AND BANTYPE = 4)";
        }
    }

    $ban_check_query = implode(" OR ", $ban_check_array);

    if (defined("BEEHIVE_INSTALL_NOWARN")) return true;

    if (strlen(trim($ban_check_query)) > 0) {

        $sql = "SELECT ID FROM {$table_data['PREFIX']}BANNED ";
        $sql.= "WHERE $ban_check_query LIMIT 0, 1";

        $result = db_query($sql, $db_ban_check);

        if (db_num_rows($result) > 0) {

            if (!strstr(php_sapi_name(), 'cgi')) {
                header("HTTP/1.0 500 Internal Server Error");
            }

            echo "<h1>HTTP/1.0 500 Internal Server Error</h1>";
            exit;
        }
    }

    return true;
}

function ip_is_banned($ipaddress)
{
   $db_ip_is_banned = db_connect();

   $ipaddress = addslashes($ipaddress);

   if (!$table_data = get_table_prefix()) return false;

   $sql = "SELECT ID FROM {$table_data['PREFIX']}BANNED ";
   $sql.= "WHERE '$ipaddress' LIKE BANDATA AND BANTYPE = 1 ";
   $sql.= "LIMIT 0, 1";

   $result = db_query($sql, $db_ip_is_banned);

   return (db_num_rows($result) > 0);
}

function logon_is_banned($logon)
{
   $db_logon_is_banned = db_connect();

   $logon = addslashes($logon);

   if (!$table_data = get_table_prefix()) return false;

   $sql = "SELECT ID FROM {$table_data['PREFIX']}BANNED ";
   $sql.= "WHERE '$logon' LIKE BANDATA AND BANTYPE = 2 ";
   $sql.= "LIMIT 0, 1";

   $result = db_query($sql, $db_logon_is_banned);

   return (db_num_rows($result) > 0);
}

function nickname_is_banned($nickname)
{
   $db_nickname_is_banned = db_connect();

   $nickname = addslashes($nickname);

   if (!$table_data = get_table_prefix()) return false;

   $sql = "SELECT ID FROM {$table_data['PREFIX']}BANNED ";
   $sql.= "WHERE '$nickname' LIKE BANDATA AND BANTYPE = 3 ";
   $sql.= "LIMIT 0, 1";

   $result = db_query($sql, $db_nickname_is_banned);

   return (db_num_rows($result) > 0);
}

function email_is_banned($email)
{
   $db_email_is_banned = db_connect();

   $email = addslashes($email);

   if (!$table_data = get_table_prefix()) return false;

   $sql = "SELECT ID FROM {$table_data['PREFIX']}BANNED ";
   $sql.= "WHERE '$email' LIKE BANDATA AND BANTYPE = 4 ";
   $sql.= "LIMIT 0, 1";

   $result = db_query($sql, $db_email_is_banned);

   return (db_num_rows($result) > 0);
}

function referer_is_banned($referer)
{
   $db_referer_is_banned = db_connect();

   $referer = addslashes($referer);

   if (!$table_data = get_table_prefix()) return false;

   $sql = "SELECT ID FROM {$table_data['PREFIX']}BANNED ";
   $sql.= "WHERE '$referer' LIKE BANDATA AND BANTYPE = 5 ";
   $sql.= "LIMIT 0, 1";

   $result = db_query($sql, $db_referer_is_banned);

   return (db_num_rows($result) > 0);
}

function add_ban_data($type, $data, $comment)
{
    $db_add_ban_data = db_connect();

    $data_types_array = array(BAN_TYPE_IP, BAN_TYPE_LOGON, BAN_TYPE_NICK, BAN_TYPE_EMAIL, BAN_TYPE_REF);

    if (!in_array($type, $data_types_array)) return false;

    $data = addslashes($data);
    $comment = addslashes($comment);

    if (!$table_data = get_table_prefix()) return false;

    $sql = "INSERT INTO {$table_data['PREFIX']}BANNED ";
    $sql.= "(BANTYPE, BANDATA, COMMENT) VALUES ('$type', '$data', '$comment')";

    return db_query($sql, $db_add_ban_data);
}

function remove_ban_data_by_id($ban_id)
{
    $db_remove_ban_data = db_connect();

    if (!is_numeric($ban_id)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $sql = "DELETE FROM {$table_data['PREFIX']}BANNED ";
    $sql.= "WHERE ID = '$ban_id'";

    if (!$result = db_query($sql, $db_remove_ban_data)) return false;

    return (db_affected_rows($db_remove_ban_data) > 0);
}

function update_ban_data($ban_id, $type, $data, $comment)
{
    $db_remove_ban_data = db_connect();

    if (!is_numeric($ban_id)) return false;

    $data_types_array = array(BAN_TYPE_IP, BAN_TYPE_LOGON, BAN_TYPE_NICK, BAN_TYPE_EMAIL, BAN_TYPE_REF);

    if (!in_array($type, $data_types_array)) return false;

    $data = addslashes($data);
    $comment = addslashes($comment);

    if (!$table_data = get_table_prefix()) return false;

    $sql = "UPDATE {$table_data['PREFIX']}BANNED ";
    $sql.= "SET BANTYPE = '$type', BANDATA = '$data', ";
    $sql.= "COMMENT = '$comment' WHERE ID = '$ban_id'";

    if (!$result = db_query($sql, $db_remove_ban_data)) return false;

    return true;
}

function check_ban_data($ban_type, $ban_data, $check_ban_id = false)
{
    $db_referer_is_banned = db_connect();

    if (!is_numeric($ban_type)) return false;
    if (!is_numeric($check_ban_id)) $ban_id = false;
   
    $ban_data = addslashes($ban_data);

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

    $result = db_query($sql, $db_referer_is_banned);

    if (db_num_rows($result) > 0) {

        list($ban_id) = db_fetch_array($result, DB_RESULT_NUM);
        return $ban_id;
    }

    return false;
}

function check_affected_sessions($ban_type, $ban_data)
{
    $db_check_affected_sessions = db_connect();

    if (!is_numeric($ban_type)) return false;

    $ban_data = addslashes($ban_data);

    $affected_sessions = array();

    $sql = "SELECT DISTINCT SESSIONS.UID, USER.LOGON, USER.NICKNAME FROM SESSIONS ";
    $sql.= "LEFT JOIN USER USER ON (USER.UID = SESSIONS.UID) ";
    $sql.= "WHERE ((SESSIONS.IPADDRESS LIKE '$ban_data' AND $ban_type = 1) ";
    $sql.= "OR (SESSIONS.REFERER LIKE '$ban_data' AND $ban_type = 5)";
    $sql.= "OR (USER.IPADDRESS LIKE '$ban_data' AND $ban_type = 1) ";
    $sql.= "OR (USER.REFERER LIKE '$ban_data' AND $ban_type = 5)) ";
    $sql.= "AND SESSIONS.UID > 0";

    $result = db_query($sql, $db_check_affected_sessions);

    if (db_num_rows($result) > 0) {

        while ($row = db_fetch_array($result)) {
        
            $affected_sessions[$row['UID']] = $row;
        }
    }

    $sql = "SELECT COUNT(SESSIONS.UID) FROM SESSIONS ";
    $sql.= "WHERE (('$ban_data' LIKE SESSIONS.IPADDRESS AND $ban_type = 1) ";
    $sql.= "OR (SESSIONS.REFERER LIKE '$ban_data' AND $ban_type = 5)) ";
    $sql.= "AND SESSIONS.UID = 0";

    $result = db_query($sql, $db_check_affected_sessions);

    list($affected_guest_count) = db_fetch_array($result, DB_RESULT_NUM);

    for ($i = 0; $i < $affected_guest_count; $i++) {

        $affected_sessions[] = array('UID' => 0, 'LOGON' => 'GUEST', 'NICKNAME' => 'GUEST');
    }

    return (sizeof($affected_sessions) > 0) ? $affected_sessions : false;
}

?>