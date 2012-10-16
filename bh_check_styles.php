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

$exclude_dirs_array = array('default', 'tehforum');

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

function sort_array_by_array($array, $sort_by)
{
    $common_keys = array_intersect_key(array_flip($sort_by), $array);
    $common_key_values = array_intersect_key($array, $common_keys);
    return array_merge($common_keys, $common_key_values);
}

function get_css_styles($path, $pattern, $exclude_dirs_array, $exclude_files_array)
{
    $output = array();

    $directory_iterator = new DirectoryIterator($path);

    foreach ($directory_iterator as $fileinfo) {

        if ($fileinfo->isDir() && !$fileinfo->isDot() && !in_array($fileinfo->getBasename(), $exclude_dirs_array)) {

            $style_name = $fileinfo->getBasename();

            $style_pathname = $fileinfo->getPathname();

            $regex_iterator = new RegexIterator(
                new RecursiveIteratorIterator(
                    new RecursiveDirectoryIterator($style_pathname)
                ),
                $pattern,
                RegexIterator::GET_MATCH
            );

            foreach ($regex_iterator as $filename => $regex_match) {

                if (!in_array(basename($filename), $exclude_files_array)) {

                    $css_filename = ltrim(
                        str_replace(
                            $style_pathname,
                            '',
                            $filename
                        ),
                        '/'
                    );

                    if (!isset($output[$style_name])) {
                        $output[$style_name] = array();
                    }

                    $output[$style_name][$css_filename] = parse_css_to_array(file_get_contents($filename));
                }
            }
        }
    }

    return $output;
}

set_time_limit(0);

header('Content-Type: text/plain');

$style_css_files_array = get_css_styles('forum/styles/', '/\.css$/i', $exclude_dirs_array, $exclude_files_array);

$default_css_files_array = get_css_styles('forum/styles/', '/default\/.+\.css$/i', array(), $exclude_files_array);

$default_css_files_array = $default_css_files_array['default'];

foreach ($default_css_files_array as $default_css_filename => $default_css_rules) {

    foreach ($style_css_files_array as $style_name => $style_css_files) {

        if (!isset($style_css_files_array[$style_name][$default_css_filename])) {

            $style_css_files_array[$style_name][$default_css_filename] = $default_css_rules;
            continue;
        }

        foreach ($default_css_rules as $default_css_selector => $default_css_properties) {

            if (!isset($style_css_files_array[$style_name][$default_css_filename][$default_css_selector])) {

                $style_css_files_array[$style_name][$default_css_filename][$default_css_selector] = $default_css_properties;
                continue;
            }

            foreach ($default_css_properties as $default_property_name => $default_property_value) {

                if (preg_match('/(#[0-9A-F]{3,6}|rgba?)/i', $default_property_value) > 0) {
                    continue;
                }

                if (preg_match('/color/i', $default_property_name) > 0) {
                    continue;
                }

                $style_css_files_array[$style_name][$default_css_filename][$default_css_selector][$default_property_name] = $default_property_value;
            }

            sort_array_by_array(
                $style_css_files_array[$style_name][$default_css_filename][$default_css_selector],
                array_keys($default_css_files_array[$default_css_filename][$default_css_selector])
            );
        }

        foreach ($style_css_files as $style_css_filename => $style_css_rules) {

            foreach ($style_css_rules as $style_css_selector => $style_css_properties) {

                if (!isset($default_css_files_array[$style_css_filename][$style_css_selector])) {
                    unset($style_css_files_array[$style_name][$style_css_filename][$style_css_selector]);
                }
            }
        }

        sort_array_by_array(
            $style_css_files_array[$style_name][$default_css_filename],
            array_keys($default_css_files_array[$default_css_filename])
        );
    }
}

foreach ($style_css_files_array as $style_name => $style_css_files) {

    foreach ($style_css_files as $style_css_filename => $style_css_rules) {

        file_put_contents(
            sprintf(
                'forum/styles/%s/%s',
                $style_name,
                $style_css_filename
            ),
            parse_array_to_css($style_css_rules)
        );
    }
}

?>