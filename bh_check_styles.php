<?php

/*======================================================================
Copyright Project BeehiveForum 2002

This file is part of BeehiveForum.

BeehiveForum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
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

date_default_timezone_set('UTC');

define("BH_INCLUDE_PATH", "./forum/include/");

define("BEEHIVEMODE_LIGHT", true);

require_once BH_INCLUDE_PATH. 'errorhandler.inc.php';

require_once BH_INCLUDE_PATH. 'format.inc.php';

$exclude_files_array = array('start_main.css', 'style_ie6.css', 'gallery.css');

$exclude_dirs_array = array('forum/styles/default');

function get_file_list(&$file_list_array, $path, $extension)
{
    $extension_preg = preg_quote($extension, '/');

    if (!is_array($file_list_array)) $file_list_array = array();

    if (($dir_handle = opendir($path))) {

        while (($file_name = readdir($dir_handle)) !== false) {

            if ($file_name != "." && $file_name != "..") {

                if (@is_dir("$path/$file_name") && !in_array("$path/$file_name", $GLOBALS['exclude_dirs_array'])) {

                    get_file_list($file_list_array, "$path/$file_name", $extension);

                } else if ((preg_match("/$extension_preg$/iu", $file_name) > 0) && !in_array($file_name, $GLOBALS['exclude_files_array'])) {

                    $file_list_array[] = "$path/$file_name";
                }
            }
        }
    }
}

function parse_css_to_array($css_file_contents)
{
    $css_rules_array = array();

    preg_match_all('/([^}]+){([^}]+)}/im', $css_file_contents, $rule_matches_array, PREG_SET_ORDER);

    foreach ($rule_matches_array as $rule_match) {

        $selector = preg_replace('/ +/', ' ', preg_replace("/\r|\r\n|\n/", " ", trim($rule_match[1])));

        $css_rules_array[$selector] = array();

        $attributes_array = array_filter(array_map('trim', explode(';', $rule_match[2])), 'strlen');

        foreach ($attributes_array as $attribute_line) {

            list($attribute, $value) = explode(':', $attribute_line);
            $css_rules_array[$selector][trim($attribute)] = trim($value);
        }
    }

    return $css_rules_array;
}

function selector_sort($a, $b)
{
    if ($a == 'html' && $b == 'body') return -1;
    if ($a == 'body' && $b == 'html') return 1;

    if ($a == 'html') return -1;
    if ($b == 'html') return 1;

    if ($a == 'body') return -1;
    if ($b == 'body') return 1;

    if (substr($a, 0, 1) == '.' && substr($b, 0, 1) != '.') return 1;
    if (substr($a, 0, 1) != '.' && substr($b, 0, 1) == '.') return -1;

    return strcmp($a, $b);
}

function sort_array_by_array($array, $sort_by)
{
    $common_keys = array_intersect_key(array_flip($sort_by), $array);
    $common_key_values = array_intersect_key($array, $common_keys);
    return array_merge($common_keys, $common_key_values);
}

function parse_array_to_css($css_rules_array)
{
    $css_file_contents = '';

    foreach ($css_rules_array as $selector => $rules_set) {

        ksort($rules_set);

        $selector = implode(",\n", array_map('trim', explode(',', $selector)));

        $css_file_contents.= sprintf(
            "%s {\n    %s;\n}\n\n",
            $selector,
            implode_assoc($rules_set, ': ', ";\n    ")
        );
    }

    return trim($css_file_contents);
}

function array_diff_key_recursive($array1, $array2)
{
    foreach ($array1 as $key => $value) {

        if (is_array($value) && array_key_exists($key, $array2)) {

            $result[$key] = array_diff_key_recursive($array1[$key], $array2[$key]);

        } else if (is_array($value)) {

            $result[$key] = $array1[$key];

        } else {

            $result = array_diff_key($array1, $array2);
        }

        if (is_array($result) && isset($result[$key]) && is_array($result[$key]) && count($result[$key]) == 0) {
            unset($result[$key]);
        }
    }

    return $result;
}

set_time_limit(0);

header('Content-Type: text/plain');

$css_rules_array = array();

get_file_list($file_list, 'forum/styles', 'style.css');

get_file_list($file_list, 'forum/styles', 'mobile.css');

foreach ($file_list as $css_filepath) {
    $css_rules_array[$css_filepath] = parse_css_to_array(file_get_contents($css_filepath));
}

foreach ($css_rules_array as $css_filepath => $css_rules_set) {

    $default_css_filepath = sprintf(
        'forum/styles/default/%s',
        basename($css_filepath)
    );

    $default_css_rules = parse_css_to_array(file_get_contents($default_css_filepath));

    file_put_contents($default_css_filepath, parse_array_to_css($default_css_rules));

    $default_css_rules = parse_css_to_array(file_get_contents($default_css_filepath));

    foreach ($default_css_rules as $selector => $default_rules_set) {

        if (!isset($css_rules_set[$selector])) {

            $css_rules_set[$selector] = $default_rules_set;

        } else {

            foreach ($default_rules_set as $rule_name => $value) {

                if (preg_match('/(#[0-9A-F]{3,6}|rgba?)/i', $value) > 0) {
                    continue;
                }

                if (preg_match('/color/i', $rule_name) > 0) {
                    continue;
                }

                $css_rules_set[$selector][$rule_name] = $value;
            }
        }
    }

    foreach ($css_rules_set as $selector => $css_rules) {

        if (!isset($default_css_rules[$selector])) {
            unset($css_rules_set[$selector]);
        }
    }

    file_put_contents($css_filepath, parse_array_to_css($css_rules_set));
}

?>