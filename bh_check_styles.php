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

/* $Id: bh_check_styles.php,v 1.12 2008-07-28 21:05:47 decoyduck Exp $ */

function item_preg_callback(&$item, $key, $delimiter)
{
    $item = preg_quote($item, $delimiter);
}

function item_trim_callback(&$item, $key)
{
    $item = trim($item);
}

$styles_dir = "forum/styles";

$style_errors = array();

if (file_exists("$styles_dir/default/style.css")) {

    // Default theme

    $default_style_file = file_get_contents("$styles_dir/default/style.css");
    preg_match_all("/([^\{]+)(\{[^\}]+\})/i", $default_style_file, $matches_array);
    array_walk($matches_array[1], 'item_trim_callback');
    $default_style_array = $matches_array[1];

    // make_style.css

    $default_style_file = file_get_contents("$styles_dir/make_style.css");
    preg_match_all("/([^\{]+){[^\}]+}/i", $default_style_file, $matches_array);
    array_walk($matches_array[1], 'item_trim_callback');
    $style_file_array['make_style.css'] = $matches_array[1];

    // main style.css (when no DEFAULT)

    $default_style_file = file_get_contents("$styles_dir/style.css");
    preg_match_all("/([^\{]+){[^\}]+}/i", $default_style_file, $matches_array);
    array_walk($matches_array[1], 'item_trim_callback');
    $style_file_array['style.css'] = $matches_array[1];

    if (is_dir($styles_dir)) {

        if (($dir = opendir($styles_dir))) {

            while (($file = readdir($dir)) !== false) {

                if (($file != "." && $file != ".." && file_exists("$styles_dir/$file/style.css"))) {

                    $style_file = file_get_contents("$styles_dir/$file/style.css");
                    preg_match_all("/([^\{]+){[^\}]+}/i", $style_file, $matches_array);
                    array_walk($matches_array[1], 'item_trim_callback');
                    $style_file_array[$file] = $matches_array[1];
                }
            }
        }

        closedir($dir);
    }

    $default_style_array_preg = $default_style_array;
    array_walk($default_style_array_preg, 'item_preg_callback', '/');
    $default_style_array_preg = implode('$|^', $default_style_array_preg);

    foreach ($style_file_array as $style_file => $style_class_array) {

        $classes_deprecated[$style_file] = preg_grep("/^$default_style_array_preg$/i", $style_class_array, PREG_GREP_INVERT);

        $style_file_matches_preg = $style_class_array;
        array_walk($style_file_matches_preg, 'item_preg_callback', '/');
        $style_file_matches_preg = implode('$|^', $style_file_matches_preg);

        $classes_missing[$style_file] = preg_grep("/^$style_file_matches_preg$/i", $default_style_array, PREG_GREP_INVERT);
    }

    $shown_header_deprecated = false;
    $shown_header_missing = false;

    $shown_deprecated_results = false;
    $shown_missing_results = false;

    foreach ($classes_deprecated as $style_file => $style_classes_array) {

        if ($style_file != 'make_style.css') {

            if (sizeof($style_classes_array) > 0) {

                $shown_deprecated_results = true;

                if ($shown_header_deprecated === false) {

                    echo "Deprecated Classes\n==================\n\n";
                    $shown_header_deprecated = true;
                }

                echo $style_file, "\n", str_repeat("-", strlen($style_file)), "\n\n";

                foreach ($style_classes_array as $deprecated_class) {
                    echo $deprecated_class, "\n";
                }

                echo "\n\n\n";
            }
        }
    }

    if ($shown_deprecated_results === false) {

        echo "Deprecated Classes\n==================\n\n";
        echo "No deprecated classes in CSS files.\n\n";
    }

    foreach ($classes_missing as $style_file => $style_classes_array) {

        if (sizeof($style_classes_array) > 0) {

            $shown_missing_results = true;

            if ($shown_header_missing === false) {

                echo "Missing Classes\n==================\n\n";
                $shown_header_missing = true;
            }

            echo $style_file, "\n", str_repeat("-", strlen($style_file)), "\n\n";

            foreach ($style_classes_array as $missing_class) {
                echo $missing_class, "\n";
            }

            echo "\n\n\n";
        }
    }

    if ($shown_missing_results === false) {

        echo "Missing Classes\n==================\n\n";
        echo "No missing classes in CSS files.\n\n";
    }
}

?>