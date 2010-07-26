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

/* $Id$ */

// Set the default timezone

date_default_timezone_set('UTC');

// Constant to define where the include files are

define("BH_INCLUDE_PATH", "./forum/include/");

// Mimic Lite Mode

define("BEEHIVEMODE_LIGHT", true);

// Enable the error handler

include_once(BH_INCLUDE_PATH. "errorhandler.inc.php");

// Database functions.

include_once(BH_INCLUDE_PATH. "format.inc.php");

// Array of files to exclude from the matches

$exclude_files_array = array('start_main.css', 'make_style.css', 'style_ie6.css');

// Array of directories to exclude from the matches

$exclude_dirs_array = array('forum/styles/Default');

// Get array of files in specified directory and sub-directories.

function get_file_list(&$file_list_array, $path, $extension)
{
    $extension_preg = preg_quote($extension, '/');

    if (!is_array($file_list_array)) $file_list_array = array();

    if (($dir_handle = opendir($path))) {

        while (($file_name = readdir($dir_handle)) !== false) {

            if ($file_name != "." && $file_name != "..") {

                if (@is_dir("$path/$file_name") && !in_array("$path/$file_name", $GLOBALS['exclude_dirs_array'])) {

                    get_file_list($file_list_array, "$path/$file_name", $extension);

                }else if ((preg_match("/$extension_preg$/iu", $file_name) > 0) && !in_array($file_name, $GLOBALS['exclude_files_array'])) {

                    $file_list_array[] = "$path/$file_name";
                }
            }
        }
    }
}

// Parse the CSS file into a multi-dimensional array of
// selectors and attributes and values

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
        
        $css_file_contents.= sprintf("%s {\n    %s;\n}\n\n", wordwrap($selector, 65), implode_assoc($rules_set, ': ', ";\n    "));
    }
    
    return trim($css_file_contents);
}

function array_diff_key_recursive($array1, $array2) 
{
    foreach($array1 as $key => $value) {
        
        if (is_array($value) && array_key_exists($key, $array2)) {
            
            $result[$key] = array_diff_key_recursive($array1[$key], $array2[$key]);
        
        } else if (is_array($value)) {
            
            $result[$key] = $array1[$key];
        
        }else {
            
            $result = array_diff_key($array1, $array2);
        }

        if (is_array($result) && isset($result[$key]) && is_array($result[$key]) && count($result[$key]) == 0) {
            unset($result[$key]);
        }
    }
    
    return $result;
}

// Prevent time out

set_time_limit(0);

// Output the content as text.

header('Content-Type: text/plain');
    
// Array to hold our CSS schemes.

$css_rules_array = array();

// Get the CSS files in the main forum/styles directory

get_file_list($file_list, 'forum/styles', '.css');

// Iterate over each of the files.

foreach($file_list as $css_filepath) {
    $css_rules_array[$css_filepath] = parse_css_to_array(file_get_contents($css_filepath));
}

// Load the default style

$default_css_rules = parse_css_to_array(file_get_contents('forum/styles/Default/style.css'));

// Make backup of default style

rename('forum/styles/Default/style.css', sprintf('forum/styles/Default/style.css.%s', date('YmdHis')));

// Clean the default style and save it.

file_put_contents('forum/styles/Default/style.css', parse_array_to_css($default_css_rules));

// Debug output.
    
foreach($css_rules_array as $css_filepath => $css_rules_set) {
    
    // Remove font-size rules
    
    foreach($css_rules_set as $selector => $rules_set) {
        
        if (isset($default_css_rules[$selector]['font-size'])) {
            $css_rules_set[$selector]['font-size'] = $default_css_rules[$selector]['font-size'];
        } else {
            unset($css_rules_set[$selector]['font-size']);    
        }
    }
    
    // Remove depreceated selectors
    
    $css_rules_set = array_diff_key($css_rules_set, array_diff_key($css_rules_set, $default_css_rules));
    
    // Add the missing selectors
    
    $css_rules_set = array_merge($css_rules_set, array_diff_key($default_css_rules, $css_rules_set));
    
    $css_rules_set = sort_array_by_array($css_rules_set, array_keys($default_css_rules));
    
    // Copy the missing rules to the selectors
    
    foreach(array_diff_key_recursive($default_css_rules, $css_rules_set) as $selector => $missing_rules_set) {
        
        foreach($missing_rules_set as $rule_name => $value) {
            
            $css_rules_set[$selector][$rule_name] = $value;
        }
    }
    
    // Remove the extra rules from selectors, taking care not 
    // to remove those with the word color in them.
    
    foreach(array_diff_key_recursive($css_rules_set, $default_css_rules) as $selector => $additional_rules_set) {
        
        foreach($additional_rules_set as $rule_name => $value) {
            
            if (preg_match('/color|background-image/', $rule_name) < 1) {
                unset($css_rules_set[$selector][$rule_name]);
            }
        }
    }
    
    // Backup the original file.
    
    rename($css_filepath, sprintf("$css_filepath.%s.%s", date('YmdHis'), md5(uniqid(mt_rand()))));
    
    // Output the fixed style.
    
    file_put_contents($css_filepath, parse_array_to_css($css_rules_set));
}

// Load the make_style.css

$make_style_css_rules = parse_css_to_array(file_get_contents('forum/styles/make_style.css'));

// Remove depreceated selectors

$make_style_css_rules = array_diff_key($make_style_css_rules, array_diff_key($make_style_css_rules, $default_css_rules));

// Add the missing selectors

$make_style_css_rules = array_merge($make_style_css_rules, array_diff_key($default_css_rules, $make_style_css_rules));

// Copy the missing rules to the selectors

foreach(array_diff_key_recursive($default_css_rules, $make_style_css_rules) as $selector => $missing_rules_set) {
    
    foreach($missing_rules_set as $rule_name => $value) {
        
        $make_style_css_rules[$selector][$rule_name] = $value;
    }
}

// Remove the extra rules from selectors, taking care not 
// to remove those with the word color in them.

foreach(array_diff_key_recursive($make_style_css_rules, $default_css_rules) as $selector => $additional_rules_set) {
    
    foreach($additional_rules_set as $rule_name => $value) {
        
        if (preg_match('/color|background-image/', $rule_name) < 1) {
            unset($make_style_css_rules[$selector][$rule_name]);
        }
    }
}

// Backup the original file.

rename('forum/styles/make_style.css', sprintf('forum/styles/make_style.css.%s', date('YmdHis')));

// Output the fixed style.

file_put_contents('forum/styles/make_style.css', parse_array_to_css($make_style_css_rules));

?>