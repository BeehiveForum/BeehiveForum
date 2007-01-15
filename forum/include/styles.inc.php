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

/* $Id: styles.inc.php,v 1.12 2007-01-15 00:10:37 decoyduck Exp $ */

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "forum.inc.php");

function styles_get_available()
{
    $webtag = get_webtag($webtag_search);

    $styles = array();

    if (@$dir = opendir("./styles")) {

        while (($file = readdir($dir)) !== false) {

            if (@is_dir("styles/$file") && $file != '.' && $file != '..') {

                if (@file_exists("./styles/$file/style.css")) {

                    if (@file_exists("./styles/$file/desc.txt")) {

                        $style_name = implode("", file("./styles/$file/desc.txt"));
                        $styles[$file] = _htmlentities($style_name);

                    }else {

                        $styles[$file] = _htmlentities($file);
                    }
                }
            }
        }

        closedir($dir);
    }

    if (@$dir = opendir("./forums/$webtag/styles")) {

        while (($file = readdir($dir)) !== false) {

            if (@is_dir("./forums/$webtag/styles/$file") && $file != '.' && $file != '..') {

                if (@file_exists("./forums/$webtag/styles/$file/style.css")) {

                    if (@file_exists("./forums/$webtag/styles/$file/desc.txt")) {

                        $style_name = implode("", file("./forums/$webtag/styles/$file/desc.txt"));
                        $styles[$file] = _htmlentities($style_name);

                    }else {

                        $styles[$file] = _htmlentities($file);
                    }
                }
            }
        }

        closedir($dir);
    }

    asort($styles);
    reset($styles);

    return $styles;
}

function style_exists ($style)
{
    $webtag = get_webtag($webtag_search);

    if (@file_exists("./styles/$style/style.css")) {
        return true;
    }

    if (@file_exists("./forums/$webtag/styles/$style/style.css")) {
        return true;
    }

    return false;
}

?>