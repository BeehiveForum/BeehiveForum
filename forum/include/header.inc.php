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

// header.inc.php:
// Functions for manipulating the HTTP header
// These must be called BEFORE anything is output to the page - including blank lines outside PHP
// tags in include files, etc.

function header_no_cache()
{
    header("Expires: Mon, 08 Apr 2002 12:00:00 GMT");               // Date in the past (Beehive birthday)
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");  // always modified
    header("Cache-Control: no-store, no-cache, must-revalidate");   // HTTP/1.1
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
}

function header_redirect($uri)
{
    header("Request-URI: $uri");
    header("Content-Location: $uri");
    header("Location: $uri");
    exit;
}

?>