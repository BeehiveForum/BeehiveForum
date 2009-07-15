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

/* $Id: styles.inc.php,v 1.30 2009-07-15 11:37:27 decoyduck Exp $ */

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "compat.inc.php");
include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");

function styles_get_available()
{
    $webtag = get_webtag();

    $lang = load_language_file();

    $available_global_styles = array();
    $available_forum_styles  = array();

    if (forum_check_webtag_available($webtag)) {

        if ((@$dir = opendir("forums/$webtag/styles"))) {

            while (($file = readdir($dir)) !== false) {

                if (!in_array($file, array_keys($available_forum_styles))) {

                    if (@is_dir("forums/$webtag/styles/$file") && $file != '.' && $file != '..') {

                        if (@file_exists("forums/$webtag/styles/$file/style.css")) {

                            if (@file_exists("forums/$webtag/styles/$file/desc.txt")) {

                                $local_style_name = implode("", file("forums/$webtag/styles/$file/desc.txt"));
                                $available_forum_styles[$file] = htmlentities_array(trim($local_style_name));

                            }else {

                                $available_forum_styles[$file] = htmlentities_array(trim($file));
                            }
                        }
                    }
                }
            }

            closedir($dir);
        }
    }

    if ((@$dir = opendir("styles"))) {

        while (($file = readdir($dir)) !== false) {

            if (!in_array($file, array_keys($available_forum_styles)) && !in_array($file, array_keys($available_global_styles))) {

                if (@is_dir("styles/$file") && $file != '.' && $file != '..') {

                    if (@file_exists("styles/$file/style.css")) {

                        if (@file_exists("styles/$file/desc.txt")) {

                            $global_style_name = implode("", file("styles/$file/desc.txt"));
                            $available_global_styles[$file] = htmlentities_array(trim($global_style_name));

                        }else {

                            $available_global_styles[$file] = htmlentities_array(trim($file));
                        }
                    }
                }
            }
        }

        closedir($dir);
    }

    asort($available_global_styles);
    reset($available_global_styles);

    asort($available_forum_styles);
    reset($available_forum_styles);

    if (sizeof($available_global_styles) > 0 && sizeof($available_forum_styles) > 0) {

        return array($lang['globalstyles'] => array('subitems' => $available_global_styles),
                     $lang['forumstyles']  => array('subitems' => $available_forum_styles));

    }elseif (sizeof($available_global_styles) > 0) {

        return $available_global_styles;

    }elseif (sizeof($available_forum_styles) > 0) {

        return $available_forum_styles;
    }

    return false;
}

function style_exists($style_path)
{
    if (!is_string($style_path)) return false;

    $webtag = get_webtag();

    $style_path = basename($style_path);

    if (forum_check_webtag_available($webtag)) {

        if (@file_exists("forums/$webtag/styles/$style_path/style.css")) {
            return true;
        }
    }

    if (@file_exists("styles/$style_path/style.css")) {
        return true;
    }

    return false;
}

?>