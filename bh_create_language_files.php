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

// Array of files to exclude from the matches
$exclude_files_array = array('de.inc.php', 'en.inc.php', 'en-us.inc.php', 'fr-ca.inc.php', 'x-hacker.inc.php');

// Load Language File Function
function load_language_file($filename)
{
    $lang = array();

    include("./forum/include/languages/$filename");

    return $lang;
}

// Get array of files in specified directory and sub-directories.
function get_file_list(&$file_list_array, $path, $extension)
{
    $extension_preg = preg_quote($extension, '/');

    if (!is_array($file_list_array)) $file_list_array = array();

    if (($dir_handle = opendir($path))) {

        while (($file_name = readdir($dir_handle)) !== false) {
            
            if ($file_name != "." && $file_name != "..") {

                if (@is_dir("$path/$file_name")) {

                    get_file_list($file_list_array, "$path/$file_name", $extension);

                }else if ((preg_match("/$extension_preg$/iu", $file_name) > 0) && !in_array($file_name, $GLOBALS['exclude_files_array'])) {

                    $file_list_array[] = "$path/$file_name";
                }
            }
        }
    }
}

// Flattens an array.
function flatten_array($array, &$result_keys, &$result_values, $key_str = "")
{
    foreach ($array as $key => $value) {

        $key = (is_numeric($key) ? $key : "'{$key}'");
        
        if (is_array($value)) {

            if (strlen($key_str) > 0) {

                flatten_array($value, $result_keys, $result_values, "{$key_str}[{$key}]");

            }else {

                flatten_array($value, $result_keys, $result_values, $key);
            }

        }else {

            if (strlen($key_str) > 0) {
            
                if (!in_array("{$key_str}[{$key}]", $result_keys)) {
                
                    $result_keys[] = "{$key_str}[{$key}]";
                    $result_values[] = $value;
                }

            }else {

                if (!in_array($key, $result_keys)) {
                
                    $result_keys[] = $key;
                    $result_values[] = $value;
                }
            }
        }
    }
}

// Prevent time out
set_time_limit(0);

// Output the content as text.
header('Content-Type: text/plain');

// Get the file list
get_file_list($file_list, 'forum', '.php');

// Loop through each language file
foreach ($exclude_files_array as $lang_file) {
    
    // Load the language file.
    if (($lang = load_language_file($lang_file))) {

        // Truncate the .inc.php
        $lang_path = basename($lang_file, ".inc.php");
        
        // Check through each file individually.
        foreach ($file_list as $php_file) {

            // Load File Contents
            if ((@$php_file_contents = file_get_contents($php_file))) {

                // Look for language string usage.
                $lang_matches = array();

                $required_lang_array = array();

                $required_lang_keys = array();

                $required_lang_values = array();

                if (preg_match_all('/\$lang\[\'([^\']+)\'\]/iu', $php_file_contents, $lang_matches) > 0) {

                    // Only want one of each found matches.
                    $lang_matches = array_unique($lang_matches[1]);

                    // Iterate through the matches check and display them if not defined.
                    foreach ($lang_matches as $lang_key) {

                        if (!array_key_exists($lang_key, $required_lang_array)) {

                            $required_lang_array[$lang_key] = $lang[$lang_key];
                        }
                    }
                }

                if (sizeof($required_lang_array) > 0) {

                    ksort($required_lang_array);            

                    flatten_array($required_lang_array, $required_lang_keys, $required_lang_values, '$lang');

                    $language_file = sprintf("forum/include/languages/$lang_path/%s", basename($php_file));
                    
                    if (!is_dir("forum/include/languages/$lang_path")) {
                        mkdir("forum/include/languages/$lang_path");
                    }

                    file_put_contents($language_file, "<?php\r\n\r\n");

                    foreach ($required_lang_keys as $lang_key => $lang_key_name) {

                        $language_line = sprintf("%s = \"%s\";\r\n", $required_lang_keys[$lang_key], addcslashes($required_lang_values[$lang_key], "\n\t\"\$"));
                        file_put_contents($language_file, $language_line, FILE_APPEND);
                    }

                    file_put_contents($language_file, "\r\n?>", FILE_APPEND);
                }
            }
        }
    }
}

?>