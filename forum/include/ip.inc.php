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

/* $Id: ip.inc.php,v 1.33 2007-10-11 13:01:19 decoyduck Exp $ */

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

function get_ip_address()
{
    // Proxy server client IP detection.
    // HTTP_VIA is a special case, in that the client IP
    // address may be reversed by the proxy server
    // (identifiable by -R in the proxy server's version
    // string.)

    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        if (ereg("^([0-9]{1,3}\.){3,3}[0-9]{1,3}", $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
            return $matches[0];
        }
    }elseif (isset($_SERVER['HTTP_X_FORWARDED'])) {
        if (ereg("^([0-9]{1,3}\.){3,3}[0-9]{1,3}", $_SERVER['HTTP_X_FORWARDED'], $matches)) {
            return $matches[0];
        }
    }elseif (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
        if (ereg("^([0-9]{1,3}\.){3,3}[0-9]{1,3}", $_SERVER['HTTP_FORWARDED_FOR'], $matches)) {
            return $matches[0];
        }
    }elseif (isset($_SERVER['HTTP_FORWARDED'])) {
        if (ereg("^([0-9]{1,3}\.){3,3}[0-9]{1,3}", $_SERVER['HTTP_FORWARDED'], $matches)) {
            return $matches[0];
        }
    }elseif (isset($_SERVER['HTTP_X_COMING_FROM'])) {
        if (ereg("^([0-9]{1,3}\.){3,3}[0-9]{1,3}", $_SERVER['HTTP_X_COMING_FROM'], $matches)) {
            return $matches[0];
        }
    }elseif (isset($_SERVER['HTTP_COMING_FROM'])) {
        if (ereg("^([0-9]{1,3}\.){3,3}[0-9]{1,3}", $_SERVER['HTTP_COMING_FROM'], $matches)) {
            return $matches[0];
        }
    }elseif (isset($_SERVER['HTTP_VIA'])) {
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            if (ereg("^([0-9]{1,3}\.){3,3}[0-9]{1,3}", $_SERVER['HTTP_CLIENT_IP'], $matches)) {
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

    if (isset($_SERVER['REMOTE_ADDR'])) {
        if (ereg("^([0-9]{1,3}\.){3,3}[0-9]{1,3}", $_SERVER['REMOTE_ADDR'], $matches)) {
            return $matches[0];
        }
    }

    // REMOTE_ADDR unavailable (not possible?)
    // IP Address detection of proxy or client not possible.

    return false;
}

?>