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

/* $Id: banned.inc.php,v 1.6 2005-05-01 18:55:52 decoyduck Exp $ */

// banned.inc.php contains functions for checking the ban data
// against the user credentials.

include_once(BH_INCLUDE_PATH. "ip.inc.php");
include_once(BH_INCLUDE_PATH. "user.inc.php");

function ban_check($user_sess)
{
    $db_ban_check = db_connect();

    if (!is_array($user_sess)) return false;

    if (!$table_data = get_table_prefix()) return false;

    $ip_ban_count = 0;
    $logon_ban_count = 0;
    $nickname_ban_count = 0;
    $email_ban_count = 0;

    $logon = addslashes($user_sess['LOGON']);
    $nickname = addslashes($user_sess['NICKNAME']);
    $email = addslashes($user_sess['EMAIL']);

    if ($ipaddress = get_ip_address()) {

        $sql = "SELECT COUNT(*) AS BAN_COUNT FROM {$table_data['PREFIX']}BANNED ";
        $sql.= "WHERE '$ipaddress' LIKE IPADDRESS ";

        $result = db_query($sql, $db_ban_check);
        list($ip_ban_count) = db_fetch_array($result, DB_RESULT_NUM);
    }

    if (isset($user_sess['LOGON']) && strlen(trim($user_sess['LOGON'])) > 0) {

        $sql = "SELECT COUNT(*) AS BAN_COUNT FROM {$table_data['PREFIX']}BANNED ";
        $sql.= "WHERE '$logon' LIKE LOGON";

        $result = db_query($sql, $db_ban_check);
        list($logon_ban_count) = db_fetch_array($result, DB_RESULT_NUM);
    }

    if (isset($user_sess['NICKNAME']) && strlen(trim($user_sess['NICKNAME'])) > 0) {

        $sql = "SELECT COUNT(*) AS BAN_COUNT FROM {$table_data['PREFIX']}BANNED ";
        $sql.= "WHERE '$nickname' LIKE NICKNAME";

        $result = db_query($sql, $db_ban_check);
        list($nickname_ban_count) = db_fetch_array($result, DB_RESULT_NUM);
    }

    if (isset($user_sess['EMAIL']) && strlen(trim($user_sess['EMAIL'])) > 0) {

        $sql = "SELECT COUNT(*) AS BAN_COUNT FROM {$table_data['PREFIX']}BANNED ";
        $sql.= "WHERE '$email' LIKE EMAIL";

        $result = db_query($sql, $db_ban_check);
        list($email_ban_count) = db_fetch_array($result, DB_RESULT_NUM);
    }

    $ban_count = $ip_ban_count + $logon_ban_count;
    $ban_count+= $nickname_ban_count + $email_ban_count;

    if ($ban_count > 0) {

        if (!strstr(php_sapi_name(), 'cgi')) {
            header("HTTP/1.0 500 Internal Server Error");
        }

        echo "<h1>HTTP/1.0 500 Internal Server Error</h1>";
        exit;

    }else {

        return ($ban_count > 0);
    }
}

function ip_is_banned($ipaddress)
{
   $db_ip_is_banned = db_connect();

   $ipaddress = addslashes($ipaddress);

   if (!$table_data = get_table_prefix()) return false;

   $sql = "SELECT COUNT(*) AS BAN_COUNT FROM {$table_data['PREFIX']}BANNED ";
   $sql.= "WHERE '$ipaddress' LIKE IPADDRESS";

   $result = db_query($sql, $db_ip_is_banned);
   list($ip_ban_count) = db_fetch_array($result, DB_RESULT_NUM);

   return ($ip_ban_count > 0);
}

function logon_is_banned($logon)
{
   $db_logon_is_banned = db_connect();

   $logon = addslashes($logon);

   if (!$table_data = get_table_prefix()) return false;

   $sql = "SELECT COUNT(*) AS BAN_COUNT FROM {$table_data['PREFIX']}BANNED ";
   $sql.= "WHERE '$logon' LIKE LOGON";

   $result = db_query($sql, $db_logon_is_banned);
   list($logon_ban_count) = db_fetch_array($result, DB_RESULT_NUM);

   return ($logon_ban_count > 0);
}

function nickname_is_banned($nickname)
{
   $db_nickname_is_banned = db_connect();

   $nickname = addslashes($nickname);

   if (!$table_data = get_table_prefix()) return false;

   $sql = "SELECT COUNT(*) AS BAN_COUNT FROM {$table_data['PREFIX']}BANNED ";
   $sql.= "WHERE '$nickname' LIKE NICKNAME";

   $result = db_query($sql, $db_nickname_is_banned);
   list($nickname_ban_count) = db_fetch_array($result, DB_RESULT_NUM);

   return ($nickname_ban_count > 0);
}

function email_is_banned($email)
{
   $db_email_is_banned = db_connect();

   $email = addslashes($email);

   if (!$table_data = get_table_prefix()) return false;

   $sql = "SELECT COUNT(*) AS BAN_COUNT FROM {$table_data['PREFIX']}BANNED ";
   $sql.= "WHERE '$email' LIKE EMAIL";

   $result = db_query($sql, $db_email_is_banned);
   list($email_ban_count) = db_fetch_array($result, DB_RESULT_NUM);

   return ($email_ban_count > 0);
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