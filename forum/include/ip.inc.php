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

require_once("./include/db.inc.php");
require_once("./include/forum.inc.php");
require_once("./include/constants.inc.php");

function ip_check()
{
    global $HTTP_SERVER_VARS;

    $db_ip_banned = db_connect();

    $sql = "SELECT IP FROM " . forum_table("BANNED_IP") . " WHERE IP = \"" . $HTTP_SERVER_VARS['REMOTE_ADDR'] . "\"";

    $result = db_query($sql, $db_ip_banned);

    if(db_num_rows($result)>0){
        header("HTTP/1.0 403 Forbidden");
        exit();
    }
}

function ban_ip($ipaddress)
{

   $db_ban_ip = db_connect();

   $sql = "INSERT INTO " . forum_table("BANNED_IP") . " (IP) VALUES ('$ipaddress')";
   $result = db_query($sql, $db_ban_ip);

   return $result;

}

function unban_ip($ipaddress)
{

   $db_ban_ip = db_connect();

   $sql = "DELETE FROM " . forum_table("BANNED_IP") . " WHERE IP = '$ipaddress'";
   $result = db_query($sql, $db_ban_ip);

   return $result;

}

function ip_is_banned($ipaddress)
{

   $db_ip_is_banned = db_connect();

   $sql = "SELECT IP FROM " . forum_table("BANNED_IP") . " WHERE IP = '$ipaddress'";
   $result = db_query($sql, $db_ip_is_banned);

   return (db_num_rows($result) > 0);

}

?>