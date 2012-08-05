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

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "./forum/include/");

require_once BH_INCLUDE_PATH. 'format.inc.php';

// Prevent time out
set_time_limit(0);

// Output the content as text.
header('Content-Type: text/plain');

$exclude_files_array = array();

$exclude_dirs_array = array('forum/chat', 'forum/include/languages', 'forum/include/swift');

function get_language_file($filename)
{
    $lang = array();

    include("./forum/include/languages/$filename");

    return $lang;
}

function get_file_list(&$file_list_array, $path, $extension)
{
    $extension_preg = preg_quote($extension, '/');

    if (!is_array($file_list_array)) $file_list_array = array();

    if (($dir_handle = opendir($path))) {

        while (($file_name = readdir($dir_handle)) !== false) {

            if ($file_name != "." && $file_name != "..") {

                if (@is_dir("$path/$file_name") && !in_array("$path/$file_name", $GLOBALS['exclude_dirs_array'])) {

                    get_file_list($file_list_array, "$path/$file_name", $extension);

                } else if ((preg_match("/$extension_preg$/iu", $file_name) > 0) && !in_array("$path/$file_name", $GLOBALS['exclude_files_array'])) {

                    $file_list_array[] = "$path/$file_name";
                }
            }
        }
    }

    return sizeof($file_list_array) > 0;
}

function trim_quotes($string)
{
    return trim($string, "'");
}

set_time_limit(0);

header('Content-Type: text/plain');

$lang = get_language_file("en.inc.php");

if (get_file_list($file_list_array, 'forum', '.php')) {

    echo "Please wait, checking files...\n\n";

    foreach ($file_list_array as $file_path_name) {

        if (!($file_contents = @file_get_contents($file_path_name))) {
            continue;
        }

        preg_match_all('/\$lang\[([^\]]+)\]/', $file_contents, $matches_array);
        
        $matches_array = array_map('trim_quotes', $matches_array[1]);
        
        foreach ($matches_array as $match) {
            
            $file_contents = preg_replace(
                sprintf('/{\$lang\[\'%s\'\]}/', preg_quote($match, '/')),
                sprintf('", gettext("%s"), "', $lang[$match]),
                $file_contents
            );

            $file_contents = preg_replace(
                sprintf('/\$lang\[\'%s\'\]/', preg_quote($match, '/')),
                sprintf('gettext("%s")', $lang[$match]),
                $file_contents
            );
        }
        
        file_put_contents($file_path_name, $file_contents);
    }
}

?>