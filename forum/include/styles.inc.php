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

/* $Id: styles.inc.php,v 1.5 2004-04-28 20:38:59 decoyduck Exp $ */

function style_get_styles()
{
    $webtag = get_webtag($webtag_search);

    $styles = array();

    if ($dir = @opendir("./styles")) {

        while (($file = readdir($dir)) !== false) {

            if (is_dir("styles/$file") && $file != '.' && $file != '..') {

                if (@file_exists("./styles/$file/style.css")) {

                    if ($fp = fopen("./styles/$file/desc.txt", "r")) {

                        $content = fread($fp, filesize("./styles/$file/desc.txt"));
                        $content = split("\n", $content);
                        $styles[$file] = _htmlentities($content[0]);
                        fclose($fp);

                    }else {

                        $styles[$file] = _htmlentities($file);
                    }
                }
            }
        }

        closedir($dir);
    }

    if ($dir = @opendir("./forums/$webtag/styles")) {

        while (($file = readdir($dir)) !== false) {

            if (is_dir("./forums/$webtag/styles/$file") && $file != '.' && $file != '..') {

                if (@file_exists("./forums/$webtag/styles/$file/style.css")) {

                    if ($fp = fopen("./forums/$webtag/styles/$file/desc.txt", "r")) {

                        $content = fread($fp, filesize("./forums/$webtag/styles/$file/desc.txt"));
                        $content = split("\n", $content);
                        $styles[$file] = _htmlentities($content[0]);
                        fclose($fp);

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
    if (@file_exists("./styles/$style/style.css")) {
        return true;
    }

    return false;
}

?>