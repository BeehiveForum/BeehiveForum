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

/* $Id: ip.inc.php,v 1.13 2003-09-16 12:34:43 decoyduck Exp $ */

require_once("./include/db.inc.php");
require_once("./include/forum.inc.php");
require_once("./include/constants.inc.php");

function ip_check()
{
    global $HTTP_SERVER_VARS;

    $db_ip_banned = db_connect();

    if ($ipaddress = get_ip_address()) {

        $sql = "SELECT IP FROM ". forum_table("BANNED_IP"). " WHERE IP = '$ipaddress'";
        $result = db_query($sql, $db_ip_banned);

        if (db_num_rows($result) > 0) {
            if (!strstr(php_sapi_name(), 'cgi')) {
                header("HTTP/1.0 500 Internal Server Error");
            }else {
                echo "<h1>HTTP/1.0 500 Internal Server Error</h1>\n";
                exit;
            }

        }
    }
}


function ban_ip($ipaddress)
{
   $db_ban_ip = db_connect();

   $sql = "INSERT INTO ". forum_table("BANNED_IP"). " (IP) VALUES ('$ipaddress')";
   $result = db_query($sql, $db_ban_ip);

   return $result;
}

function unban_ip($ipaddress)
{
   $db_ban_ip = db_connect();

   $sql = "DELETE FROM ". forum_table("BANNED_IP"). " WHERE IP = '$ipaddress'";
   $result = db_query($sql, $db_ban_ip);

   return $result;
}

function ip_is_banned($ipaddress)
{
   $db_ip_is_banned = db_connect();

   $sql = "SELECT IP FROM ". forum_table("BANNED_IP"). " WHERE IP = '$ipaddress'";
   $result = db_query($sql, $db_ip_is_banned);

   return (db_num_rows($result) > 0);
}

function get_ip_address()
{
    global $HTTP_SERVER_VARS;

    // Proxy server client IP detection.
    // HTTP_VIA is a special case, in that the client IP
    // address may be reversed by the proxy server
    // (identifiable by -R in the proxy server's version
    // string.)

    if (isset($HTTP_SERVER_VARS['HTTP_X_FORWARDED_FOR'])) {
        if (ereg("^([0-9]{1,3}\.){3,3}[0-9]{1,3}", $HTTP_SERVER_VARS['HTTP_X_FORWARDED_FOR'], $matches)) {
            return $matches[0];
        }
    }elseif (isset($HTTP_SERVER_VARS['HTTP_X_FORWARDED'])) {
        if (ereg("^([0-9]{1,3}\.){3,3}[0-9]{1,3}", $HTTP_SERVER_VARS['HTTP_X_FORWARDED'], $matches)) {
            return $matches[0];
        }
    }elseif (isset($HTTP_SERVER_VARS['HTTP_FORWARDED_FOR'])) {
        if (ereg("^([0-9]{1,3}\.){3,3}[0-9]{1,3}", $HTTP_SERVER_VARS['HTTP_FORWARDED_FOR'], $matches)) {
            return $matches[0];
        }
    }elseif (isset($HTTP_SERVER_VARS['HTTP_FORWARDED'])) {
        if (ereg("^([0-9]{1,3}\.){3,3}[0-9]{1,3}", $HTTP_SERVER_VARS['HTTP_FORWARDED'], $matches)) {
            return $matches[0];
        }
    }elseif (isset($HTTP_SERVER_VARS['HTTP_X_COMING_FROM'])) {
        if (ereg("^([0-9]{1,3}\.){3,3}[0-9]{1,3}", $HTTP_SERVER_VARS['HTTP_X_COMING_FROM'], $matches)) {
            return $matches[0];
        }
    }elseif (isset($HTTP_SERVER_VARS['HTTP_COMING_FROM'])) {
        if (ereg("^([0-9]{1,3}\.){3,3}[0-9]{1,3}", $HTTP_SERVER_VARS['HTTP_COMING_FROM'], $matches)) {
            return $matches[0];
        }
    }elseif (isset($HTTP_SERVER_VARS['HTTP_VIA'])) {
        if (isset($HTTP_SERVER_VARS['HTTP_CLIENT_IP'])) {
            if (ereg("^([0-9]{1,3}\.){3,3}[0-9]{1,3}", $HTTP_SERVER_VARS['HTTP_COMING_FROM'], $matches)) {
                if (strstr($HTTP_SERVER_VARS['HTTP_VIA'], "-R")) {
                    return join('.', array_reverse(explode('.', $matches[0])));
                }else {
                    return $matches[0];
                }
            }
        }
    }

    // No proxy server or client IP not accessible.
    // Resort to using the REMOTE_ADDR variable.

    if (isset($HTTP_SERVER_VARS['REMOTE_ADDR'])) {
        if (ereg("^([0-9]{1,3}\.){3,3}[0-9]{1,3}", $HTTP_SERVER_VARS['REMOTE_ADDR'], $matches)) {
            return $matches[0];
        }
    }

    // REMOTE_ADDR unavailable (not possible?)
    // IP Address detection of proxy or client not possible.

    return false;
}

?>