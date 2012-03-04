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

/**
* ip.inc.php - IP Address related functions
*
* Contains functions for fetching and checking IP addresses.
*/

/**
*
*/

// We shouldn't be accessing this file directly.
if (basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}


/**
* Get Client IP
*
* Gets the Client's IP Address. Checks for various proxy HTTP headers for client IP.
*
* @return mixed - Client's IP Address or false on failure.
* @param void
*/

function get_ip_address()
{
    // Proxy server client IP detection.
    // HTTP_VIA is a special case, in that the client IP
    // address may be reversed by the proxy server
    // (identifiable by -R in the proxy server's version
    // string.)
    $matches = array();

    if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && strlen(trim($_SERVER['HTTP_X_FORWARDED_FOR'])) > 0) {
        
        if (preg_match('/^([0-9]{1,3}\.){3,3}[0-9]{1,3}$/u', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
            return $matches[0];
        }
        
    }else if (isset($_SERVER['HTTP_X_FORWARDED']) && strlen(trim($_SERVER['HTTP_X_FORWARDED'])) > 0) {
        
        if (preg_match('/^([0-9]{1,3}\.){3,3}[0-9]{1,3}$/u', $_SERVER['HTTP_X_FORWARDED'], $matches)) {
            return $matches[0];
        }
    
    }else if (isset($_SERVER['HTTP_FORWARDED_FOR']) && strlen(trim($_SERVER['HTTP_FORWARDED_FOR'])) > 0) {
        
        if (preg_match('/^([0-9]{1,3}\.){3,3}[0-9]{1,3}$/u', $_SERVER['HTTP_FORWARDED_FOR'], $matches)) {
            return $matches[0];
        }
        
    }else if (isset($_SERVER['HTTP_FORWARDED']) && strlen(trim($_SERVER['HTTP_FORWARDED'])) > 0) {
        
        if (preg_match('/^([0-9]{1,3}\.){3,3}[0-9]{1,3}$/u', $_SERVER['HTTP_FORWARDED'], $matches)) {
            return $matches[0];
        }
    
    }else if (isset($_SERVER['HTTP_X_COMING_FROM']) && strlen(trim($_SERVER['HTTP_X_COMING_FROM'])) > 0) {
        
        if (preg_match('/^([0-9]{1,3}\.){3,3}[0-9]{1,3}$/u', $_SERVER['HTTP_X_COMING_FROM'], $matches)) {
            return $matches[0];
        }
    
    }else if (isset($_SERVER['HTTP_COMING_FROM']) && strlen(trim($_SERVER['HTTP_COMING_FROM'])) > 0) {
        
        if (preg_match('/^([0-9]{1,3}\.){3,3}[0-9]{1,3}$/u', $_SERVER['HTTP_COMING_FROM'], $matches)) {
            return $matches[0];
        }
        
    }else if (isset($_SERVER['HTTP_VIA']) && strlen(trim($_SERVER['HTTP_VIA'])) > 0) {
        
        if (isset($_SERVER['HTTP_CLIENT_IP']) && strlen(trim($_SERVER['HTTP_CLIENT_IP'])) > 0) {
            
            if (preg_match('/^([0-9]{1,3}\.){3,3}[0-9]{1,3}$/u', $_SERVER['HTTP_CLIENT_IP'], $matches)) {
                
                if (strstr($_SERVER['HTTP_VIA'], "-R")) {
                    return join('.', array_reverse(explode('.', $matches[0])));
                }else {
                    return $matches[0];
                }
            }
        }
    }

    // No proxy server or client IP not accessible.
    // Resort to using the REMOTE_ADDR variable.
    if (isset($_SERVER['REMOTE_ADDR']) && strlen(trim($_SERVER['REMOTE_ADDR'])) > 0) {
        
        if (preg_match('/^([0-9]{1,3}\.){3,3}[0-9]{1,3}$/u', $_SERVER['REMOTE_ADDR'], $matches)) {
            return $matches[0];
        }
    }

    // REMOTE_ADDR unavailable (not possible?)
    // IP Address detection of proxy or client not possible.
    return false;
}

/**
* Check IP Address
*
* Checks the IP Address to make sure it is correctly formatted. Supports IPV4 addresses only.
*
* @return boolean
* @param string $ip - IP Address to check.
*/

function check_ip_address($ip)
{
    $ip_check_preg = '/^([0-9]{1,2}|[01][0-9]{2}|2[0-4][0-9]|25[0-5])\.';
    $ip_check_preg.= '([0-9]{1,2}|[01][0-9]{2}|2[0-4][0-9]|25[0-5])\.';
    $ip_check_preg.= '([0-9]{1,2}|[01][0-9]{2}|2[0-4][0-9]|25[0-5])\.';
    $ip_check_preg.= '([0-9]{1,2}|[01][0-9]{2}|2[0-4][0-9]|25[0-5])$/Du';

    return (preg_match($ip_check_preg, $ip) > 0);
}

?>