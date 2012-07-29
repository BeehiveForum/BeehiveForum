<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
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
 * Contains functions for fetching and checking IP addresses.
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
 * Get the client IP Address from the HTTP headers
 * provided by the web-server.
 *
 * @author Matt Beale
 * @param void
 * @return string | mixed
 */
function get_ip_address()
{
    if (isset($_SERVER['REMOTE_ADDR']) && filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP)) {
        return $_SERVER['REMOTE_ADDR'];
    }
    
    return false;
}

/**
 * Validate IP Address
 * 
 * Check IP Address to make sure it is correctly formatted.
 *
 * @author Matt Beale
 * @param string $ip
 * @return boolean
 */
function check_ip_address($ip)
{
    return filter_var($ip, FILTER_VALIDATE_IP);
}

?>