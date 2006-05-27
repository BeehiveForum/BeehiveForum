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

/* $Id: bh_check_styles.php,v 1.4 2006-05-27 16:39:02 decoyduck Exp $ */

function item_preg_callback(&$item, $key, $delimiter) {
    $item = preg_quote($item, $delimiter);
}

function item_trim_callback(&$item, $key) {
    $item = trim($item);
}

$styles_dir = "forum/styles";

$style_errors = array();

if (file_exists("$styles_dir/default/style.css")) {

    // Default theme

    $default_style_file = file_get_contents("$styles_dir/default/style.css");
    preg_match_all("/(\.[ a-z0-9_-]+)/i", $default_style_file, $matches_array);
    array_walk($matches_array[0], 'item_trim_callback');
    $default_style_array = $matches_array[0];

    // make_style.css

    $default_style_file = file_get_contents("$styles_dir/make_style.css");
    preg_match_all("/(\.[ a-z0-9_-]+)/i", $default_style_file, $matches_array);
    array_walk($matches_array[0], 'item_trim_callback');
    $style_file_array['make_style.css'] = $matches_array[0];

    // main style.css (when no DEFAULT)

    $default_style_file = file_get_contents("$styles_dir/style.css");
    preg_match_all("/(\.[ a-z0-9_-]+)/i", $default_style_file, $matches_array);
    array_walk($matches_array[0], 'item_trim_callback');
    $style_file_array['style.css'] = $matches_array[0];

    if (is_dir($styles_dir)) {

        if ($dir = opendir($styles_dir)) {

            while (($file = readdir($dir)) !== false) {

                if ($file != "." && $file != ".." && file_exists("$styles_dir/$file/style.css")) {

                    $style_file = file_get_contents("$styles_dir/$file/style.css");
                    preg_match_all("/(\.[ a-z0-9_-]+)/i", $style_file, $matches_array);
                    array_walk($matches_array[0], 'item_trim_callback');
                    $style_file_array[$file] = $matches_array[0];
                }
            }
        }

        closedir($dir);
    }

    array_walk($default_style_array, 'item_preg_callback', '/');
    $default_style_matches = implode('$|^', $default_style_array);

    foreach($style_file_array as $style_file => $style_class_array) {

        $style_errors[$style_file] = preg_grep("/^$default_style_matches$/i", $style_class_array, PREG_GREP_INVERT);
    }

    print_r($style_errors);
}

?>