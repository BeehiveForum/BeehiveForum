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

// Required includes
// End Required includes

function header_redirect($uri, $reason = false)
{
    header("Request-URI: $uri");
    header("Content-Location: $uri");
    header("Location: $uri");
    exit;
}

function header_status($status, $message)
{
    if (headers_sent()) return;

    if (substr(php_sapi_name(), 0, 3) == 'cgi') {
        header(sprintf('Status: %s %s', $status, $message), true);
    } else if (isset($_SERVER['SERVER_PROTOCOL'])) {
        header(sprintf('%s %s %s', $_SERVER['SERVER_PROTOCOL'], $status, $message), true);
    } else {
        header(sprintf('HTTP/1.1 %s %s', $status, $message), true);
    }
}

?>