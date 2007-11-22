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

/* $Id: header.inc.php,v 1.31 2007-11-22 20:24:09 decoyduck Exp $ */

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "html.inc.php");
include_once(BH_INCLUDE_PATH. "form.inc.php");

/**
* Prevent caching of a page.
*
* Prevents caching of a page by sending headers which indicate that the page
* is always modified.
*
* @return void
* @param void
*/

function header_no_cache()
{
    header("Expires: Mon, 08 Apr 2002 12:00:00 GMT");               // Date in the past (Beehive birthday)
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");  // always modified
    header("Content-Type: text/html; charset=UTF-8");               // Internet Explorer Bug
    header("Cache-Control: no-store, no-cache, must-revalidate");   // HTTP/1.1
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
}

/**
* Redirect client to another page.
*
* Redirect client to another page. For Apache and other servers sends
* appropriate HTTP headers to correctly redirect the client to the
* specified address. For IIS we use Javascript and a backup form
* button to click.
*
* @return none - Functions exits code execution.
* @param string $uri - Address to redirect the client to.
* @param string $reason - Option text message advising the client why they're being redirected
*/

function header_redirect($uri, $reason = false)
{
    // Microsoft-IIS bug prevents redirect at same time as setting cookies.

    if (isset($_SERVER['SERVER_SOFTWARE']) && !strstr($_SERVER['SERVER_SOFTWARE'], 'Microsoft-IIS')) {

        header("Request-URI: $uri");
        header("Content-Location: $uri");
        header("Location: $uri");
        exit;

    }else {

        html_draw_top();

        // Try a Javascript redirect
        echo "<script language=\"javascript\" type=\"text/javascript\">\n";
        echo "<!--\n";
        echo "document.location.href = '$uri';\n";
        echo "//-->\n";
        echo "</script>";

        // If they're still here, Javascript's not working. Give up, give a link.
        echo "<div align=\"center\">\n";

        if (is_string($reason)) {
            echo "<p>$reason</p>";
        }

        echo form_quick_button($uri, $lang['continue'], false, "_top");

        echo "</div>\n";

        html_draw_bottom();
        exit;
    }
}

/**
* Check cache header.
*
* Checks appropriate HTTP headers for cache hits. Prevents client
* from hitting pages already in cache. Default cache is 5 minutes.
*
* @return mixed - void or no return (exit)
* @param string $seconds - Interval to check for cache (default: 5 minutes)
*/

function header_check_cache($seconds = 300)
{
    if (strstr(php_sapi_name(), 'cgi')) return false;

    if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') return false;

    if (!is_numeric($seconds)) return false;

    // Generate our last-modified and expires date stamps

    $local_last_modified = gmdate("D, d M Y H:i:s", time()). " GMT";
    $local_cache_expires = gmdate("D, d M Y H:i:s", time()). " GMT";

    // Check to see if the cache header exists.

    if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {

        $remote_last_modified = _stripslashes($_SERVER['HTTP_IF_MODIFIED_SINCE']);

        // Check to see if the cache is older than 5 minutes.

        if ((time() - strtotime($remote_last_modified)) < $seconds) {

            header("Expires: $local_cache_expires", true);
            header("Last-Modified: $remote_last_modified", true);
            header('Cache-Control: private, must-revalidate', true);

            header("HTTP/1.1 304 Not Modified");
            exit;
        }
    }

    header("Expires: $local_cache_expires", true);
    header("Last-Modified: $local_last_modified", true);
    header('Cache-Control: private, must-revalidate', true);
}

?>