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

/* $Id: banned.inc.php,v 1.9 2006-07-03 18:09:47 decoyduck Exp $ */

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

// banned.inc.php contains functions for checking the ban data
// against the user credentials.

include_once(BH_INCLUDE_PATH. "ip.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

function ban_check($user_sess)
{
    $db_ban_check = db_connect();

    if (!is_array($user_sess)) return false;
    if (!isset($user_sess['LOGON'])) return false;
    if (!isset($user_sess['NICKNAME'])) return false;
    if (!isset($user_sess['EMAIL'])) return false;

    if (!$table_data = get_table_prefix()) return false;

    $logon = addslashes($user_sess['LOGON']);
    $nickname = addslashes($user_sess['NICKNAME']);
    $email = addslashes($user_sess['EMAIL']);

    $ban_check_array = array();

    if ($ipaddress = get_ip_address()) {
        $ban_check_array[] = "'$ipaddress' LIKE IPADDRESS";
    }

    if (isset($user_sess['LOGON']) && strlen(trim($user_sess['LOGON'])) > 0) {
        $ban_check_array[] = "'$logon' LIKE LOGON";
    }

    if (isset($user_sess['NICKNAME']) && strlen(trim($user_sess['NICKNAME'])) > 0) {
        $ban_check_array[] = "'$nickname' LIKE NICKNAME";
    }

    if (isset($user_sess['EMAIL']) && strlen(trim($user_sess['EMAIL'])) > 0) {
        $ban_check_array[] = "'$email' LIKE EMAIL";
    }

    $ban_check_query = implode(" OR ", $ban_check_array);

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

    return true;
}

function ip_is_banned($ipaddress)
{
   $db_ip_is_banned = db_connect();

   $ipaddress = addslashes($ipaddress);

   if (!$table_data = get_table_prefix()) return false;

   $sql = "SELECT ID FROM {$table_data['PREFIX']}BANNED ";
   $sql.= "WHERE '$ipaddress' LIKE IPADDRESS LIMIT 0, 1";

   $result = db_query($sql, $db_ip_is_banned);

   return (db_num_rows($result) > 0);
}

function logon_is_banned($logon)
{
   $db_logon_is_banned = db_connect();

   $logon = addslashes($logon);

   if (!$table_data = get_table_prefix()) return false;

   $sql = "SELECT ID FROM {$table_data['PREFIX']}BANNED ";
   $sql.= "WHERE '$logon' LIKE LOGON LIMIT 0, 1";

   $result = db_query($sql, $db_ip_is_banned);

   return (db_num_rows($result) > 0);
}

function nickname_is_banned($nickname)
{
   $db_nickname_is_banned = db_connect();

   $nickname = addslashes($nickname);

   if (!$table_data = get_table_prefix()) return false;

   $sql = "SELECT ID FROM {$table_data['PREFIX']}BANNED ";
   $sql.= "WHERE '$nickname' LIKE NICKNAME LIMIT 0, 1";

   $result = db_query($sql, $db_ip_is_banned);

   return (db_num_rows($result) > 0);
}

function email_is_banned($email)
{
   $db_email_is_banned = db_connect();

   $email = addslashes($email);

   if (!$table_data = get_table_prefix()) return false;

   $sql = "SELECT ID FROM {$table_data['PREFIX']}BANNED ";
   $sql.= "WHERE '$email' LIKE EMAIL LIMIT 0, 1";

   $result = db_query($sql, $db_ip_is_banned);

   return (db_num_rows($result) > 0);
}

function add_ban_data($type, $data)
{
    $db_add_ban_data = db_connect();

    $data_types_array = array('IPADDRESS', 'LOGON', 'NICKNAME', 'EMAIL');

    if (!in_array($type, $data_types_array)) return false;

    $data = addslashes($data);

    if (!$table_data = get_table_prefix()) return false;

    $sql = "INSERT INTO {$table_data['PREFIX']}BANNED ";
    $sql.= "($type) VALUES ('$data')";

    return db_query($sql, $db_add_ban_data);
}

function remove_ban_data($type, $data)
{
    $db_add_ban_data = db_connect();

    $data_types_array = array('IPADDRESS', 'LOGON', 'NICKNAME', 'EMAIL');

    if (!in_array($type, $data_types_array)) return false;

    $data = addslashes($data);

    if (!$table_data = get_table_prefix()) return false;

    $sql = "DELETE FROM {$table_data['PREFIX']}BANNED ";
    $sql.= "WHERE $type = '$data'";

    return db_query($sql, $db_add_ban_data);
}

?>