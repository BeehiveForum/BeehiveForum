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

define("BH_INCLUDE_PATH", __DIR__ . "/forum/include/");

define("BEEHIVEMODE_LIGHT", true);

require_once BH_INCLUDE_PATH . 'errorhandler.inc.php';

require_once BH_INCLUDE_PATH . 'format.inc.php';

$exclude_files_array = array('style_ie6.css');

$exclude_dirs_array = array('default', 'tehforum');

function parse_css_to_array(&$css_file_contents, $selector = null)
{
    $buffer = '';

    $property = '';

    $properties = array();

    while (strlen($css_file_contents) > 0) {

        if (substr($css_file_contents, 0, 1) == '{') {

            $selector = $property . $buffer;

            $css_file_contents = substr($css_file_contents, 1);

            if (!isset($properties[$selector])) {
                $properties[$selector] = array();
            }

            $properties[$selector] = array_merge(
                $properties[$selector],
                parse_css_to_array($css_file_contents, $selector)
            );

            $buffer = '';
            $selector = '';

        } else if (substr($css_file_contents, 0, 1) == '}') {

            $css_file_contents = substr($css_file_contents, 1);
            return $properties;

        } else if ($selector) {

            if (substr($css_file_contents, 0, 1) == ':') {

                $property = trim(substr($buffer, 1));
                $buffer = '';

            } else if (substr($css_file_contents, 0, 1) == ';') {

                if (strlen(trim($property)) > 0 && strlen(trim($buffer)) > 0) {
                    $properties[$property] = trim(substr($buffer, 1));
                }

                $property = '';
                $buffer = '';
            }
        }

        $buffer .= substr($css_file_contents, 0, 1);
        $css_file_contents = substr($css_file_contents, 1);
    };

    return $properties;
}

function parse_array_to_css($css_rules_array, $indent = 0)
{
    $css_file_contents = '';

    foreach ($css_rules_array as $selector => $rules_set) {

        $selector = implode(",\n", array_map('trim', explode(',', $selector)));

        $rules = '';

        foreach ($rules_set as $property => $value) {

            if (is_array($value)) {

                $rules = parse_array_to_css($rules_set, $indent + 4);

            } else {

                $rules .= sprintf(
                    "%1\$s%2\$s: %3\$s;\n",
                    str_repeat(' ', $indent + 4),
                    $property,
                    $value
                );
            }
        }

        $css_file_contents .= sprintf(
            "\n%1\$s%3\$s {\n%2\$s%4\$s\n%1\$s}\n",
            str_repeat(' ', $indent),
            str_repeat(' ', $indent + 4),
            $selector,
            trim($rules)
        );
    }

    return $css_file_contents;
}

function sort_array_by_array(&$array, $sort_by)
{
    $common_keys = array_intersect_key(array_flip(array_keys($sort_by)), $array);
    $common_values = array_intersect_key($array, $common_keys);
    $array = array_merge($common_keys, $common_values);
}

function get_css_styles($path, $pattern, $exclude_dirs_array, $exclude_files_array)
{
    $output = array();

    $directory_iterator = new DirectoryIterator($path);

    foreach ($directory_iterator as $dirinfo) {

        /** @var DirectoryIterator $dirinfo */
        if (!$dirinfo->isDir() || $dirinfo->isDot() || in_array($dirinfo->getBasename(), $exclude_dirs_array)) {
            continue;
        }

        $style_name = $dirinfo->getBasename();

        $style_pathname = str_replace(DIRECTORY_SEPARATOR, '/', $dirinfo->getPathname());

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($style_pathname)
        );

        foreach ($iterator as $fileinfo) {

            /** @var SplFileInfo $fileinfo */
            if ($fileinfo->isDir()) {
                continue;
            }

            if (in_array($fileinfo->getBasename(), $exclude_files_array)) {
                continue;
            }

            if (!preg_match($pattern, str_replace(DIRECTORY_SEPARATOR, '/', $fileinfo->getPathname()))) {
                continue;
            }

            $css_filename = ltrim(str_replace(DIRECTORY_SEPARATOR, '/', str_replace($style_pathname, '', $fileinfo->getPathname())), '/');

            if (!isset($output[$style_name])) {
                $output[$style_name] = array();
            }

            $css_file_contents = file_get_contents($fileinfo->getPathname());
            $output[$style_name][$css_filename] = parse_css_to_array($css_file_contents);
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

    file_put_contents(
        sprintf(
            'forum/styles/default/%s',
            $default_css_filename
        ),
        trim(parse_array_to_css($default_css_rules))
    );
}

foreach ($style_css_files_array as $style_name => &$style_css_files) {

    foreach ($style_css_files as $style_css_filename => $style_css_rules) {

        $style_css_rules = array_replace_recursive(
            $default_css_files_array[$style_css_filename],
            $style_css_rules
        );

        sort_array_by_array(
            $style_css_files_array[$style_name][$style_css_filename],
            $default_css_files_array[$style_css_filename]
        );

        file_put_contents(
            sprintf(
                'forum/styles/%s/%s',
                $style_name,
                $style_css_filename
            ),
            trim(parse_array_to_css($style_css_rules))
        );
    }
}