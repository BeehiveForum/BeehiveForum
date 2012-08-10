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

$exclude_files_array = array();

$exclude_dirs_array = array();

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

set_time_limit(0);

header('Content-Type: text/plain');

$file_list_array = array();

get_file_list($file_list_array, 'forum/js', '.js');

foreach ($file_list_array as $js_filepath) {

    $path_parts = pathinfo($js_filepath);

    if (isset($path_parts['dirname']) && isset($path_parts['filename']) && isset($path_parts['extension'])) {
    
        $minified_js_filepath = sprintf(
            '%s/%s.min.%s', 
            $path_parts['dirname'], 
            $path_parts['filename'], 
            $path_parts['extension']
        ); 
        
        exec(sprintf(
            'java -jar compiler.jar --js %s --js_output_file %s', 
            escapeshellarg($js_filepath), 
            escapeshellarg($minified_js_filepath)
        ));
    }
}

$file_list_array = array();

get_file_list($file_list_array, 'forum/styles', '.css');

get_file_list($file_list_array, 'forum/emoticons', '.css');

foreach ($file_list_array as $css_filepath) {

    $path_parts = pathinfo($css_filepath);

    if (isset($path_parts['dirname']) && isset($path_parts['filename']) && isset($path_parts['extension'])) {
    
        $minified_css_filepath = sprintf(
            '%s/%s.min.%s', 
            $path_parts['dirname'], 
            $path_parts['filename'], 
            $path_parts['extension']
        ); 
        
        exec(sprintf(
            'java -jar yuicompressor.jar %s > %s', 
            escapeshellarg($css_filepath), 
            escapeshellarg($minified_css_filepath)
        ));
    }
}

?>