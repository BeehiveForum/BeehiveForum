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

/* $Id: bh_code_minify.php,v 1.1 2009-10-28 19:56:52 decoyduck Exp $ */

// Array of files to exclude from the matches

$exclude_files_array = array('make_style.css');

// Array of directories to exclude from the matches

$exclude_dirs_array = array();

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

// Get the JS files

get_file_list($file_list, 'forum/js', '.js');

// Get the CSS files

get_file_list($file_list, 'forum/styles', '.css');

// Get the Emoticon CSS files

get_file_list($file_list, 'forum/emoticons', '.css');

// Minify all the files we've found.

foreach ($file_list as $js_filepath) {

    $path_parts = pathinfo($js_filepath);

    if (isset($path_parts['dirname']) && isset($path_parts['filename']) && isset($path_parts['extension'])) {
    
        $minified_js_filepath = sprintf('%s/%s.min.%s', $path_parts['dirname'], $path_parts['filename'], $path_parts['extension']); 
        exec(sprintf('java -jar yuicompressor.jar %s > %s', escapeshellarg($js_filepath), escapeshellarg($minified_js_filepath)));
    }
}

?>