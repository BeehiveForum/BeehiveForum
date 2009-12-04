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

/* $Id: browser.inc.php,v 1.2 2009-12-04 18:22:55 decoyduck Exp $ */

// We shouldn't be accessing this file directly.

if (basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "constants.inc.php");

/**
* browser_check
*
* Allows testing of browsers by bitwise constants.
* Based on code from Wordpress, but changed to not
* polute global namespace with needless variables
*
* @param mixed $browser_check
* @return bool.
*/
function browser_check($browser_check = null)
{
    $browser = BROWSER_UNKNOWN;

    if (isset($_SERVER['HTTP_USER_AGENT'])) {

        if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'lynx') !== false) {

            $browser = $browser | BROWSER_LYNX;

        } elseif (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'chrome') !== false) {

            $browser = $browser | BROWSER_CHROME;

        } elseif (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'safari') !== false) {

            $browser = $browser | BROWSER_SAFARI;

        } elseif (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'konqueror') !== false) {

            $browser = $browser | BROWSER_KONQUEROR;

        } elseif (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'gecko') !== false) {

            $browser = $browser | BROWSER_GECKO;

        } elseif ((strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'msie') !== false)) {

            $browser = $browser | BROWSER_MSIE;

        } elseif (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'opera') !== false) {

            $browser = $browser | BROWSER_OPERA;

        } elseif (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'nav') !== false) {

            if (strpos($_SERVER['HTTP_USER_AGENT'], 'Mozilla/4.') !== false) {

                $browser = $browser | BROWSER_NETSCAPE4;
            }
        }

        if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'webkit') !== false) {
            $browser = $browser | BROWSER_WEBKIT;
        }

        if ((($browser & BROWSER_SAFARI) > 0) && strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'mobile') !== false) {
            $browser = $browser | BROWSER_IPHONE;
        }

        if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'msie 7') !== false) {
            $browser = $browser | BROWSER_MSIE7;
        }

        if (($browser & BROWSER_MSIE) > 0) {

            if (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'win') !== false) {

                $browser = $browser | BROWSER_MSIE_WIN;

            } elseif (strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'mac') !== false) {

                $browser = $browser | BROWSER_MSIE_MAC;
            }
        }
    }

    return (isset($browser_check)) ? ($browser & $browser_check > 0) : $browser;
}

?>