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

/* $Id: header.inc.php,v 1.18 2004-10-27 22:33:17 decoyduck Exp $ */

include_once("./include/lang.inc.php");
include_once("./include/html.inc.php");
include_once("./include/form.inc.php");

function header_no_cache()
{
    $lang = load_language_file();

    header("Expires: Mon, 08 Apr 2002 12:00:00 GMT");               // Date in the past (Beehive birthday)
    header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");  // always modified
    header("Content-Type: text/html; charset={$lang['_charset']}"); // Internet Explorer Bug
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

function header_redirect_cookie($uri)
{
    // Microsoft-IIS bug prevents redirect at same time as setting cookies.

        if (isset($_SERVER['SERVER_SOFTWARE']) && !strstr($_SERVER['SERVER_SOFTWARE'], 'Microsoft-IIS')) {
                header_redirect($uri);
        } else {
        html_draw_top();

        // Try a Javascript redirect
        echo "<script language=\"javascript\" type=\"text/javascript\">\n";
        echo "<!--\n";
        echo "document.location.href = '$uri';\n";
        echo "//-->\n";
        echo "</script>";

        // If they're still here, Javascript's not working. Give up, give a link.
        echo "<div align=\"center\"><p>&nbsp;</p><p>&nbsp;</p>";
        echo "<p>{$lang['preferencesupdated']}</p>";

        form_quick_button($uri, $lang['continue'], false, false, "_top");

        html_draw_bottom();
        exit;
    }
}

?>
