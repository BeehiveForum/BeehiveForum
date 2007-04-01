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

/* $Id: bh_check_dependencies.php,v 1.18 2007-04-01 20:41:38 decoyduck Exp $ */

// Path to include files.

$include_files_dir   = "forum/include";

// Array of functions and constants

$include_files_array = array("\$lang" => "lang.inc.php");

// Path to source files.

$source_files_dir_array = array("forum", "forum/include");

echo "Getting list of functions...\n";

foreach($source_files_dir_array as $include_file_dir) {

    if ($dir = @opendir($include_file_dir)) {

        while (($file = readdir($dir)) !== false) {

            $path_info_array = pathinfo("$include_file_dir/$file");

            if (isset($path_info_array['extension']) && $path_info_array['extension'] == 'php') {

                $source_files_array[] = "$include_file_dir/$file";
                $source_file_contents = file_get_contents("$include_file_dir/$file");

                if (preg_match_all("/function\s([a-z1-9-_]+)[\s]?\(/i", $source_file_contents, $function_matches)) {

                    $function_matches = array_flip($function_matches[1]);
                    array_walk($function_matches, create_function('&$elem', "\$elem = \"$file\";"));
                    $include_files_array = array_merge($include_files_array, $function_matches);
                }

                if (preg_match_all("/define[ ]?\([\"|']?([a-z1-9-_]+)/i", $source_file_contents, $constant_matches)) {

                    $constant_matches = array_flip($constant_matches[1]);
                    array_walk($constant_matches, create_function('&$elem', "\$elem = \"$file\";"));
                    $include_files_array = array_merge($include_files_array, $constant_matches);
                }
            }
        }
    }
}            

echo "Processing files...\n\n";

foreach($source_files_array as $source_file) {

    $include_files_required_array = array();

    $source_file_contents = file_get_contents($source_file);

    $header_display = false;

    foreach($include_files_array as $function_name => $include_file) {

        if ($include_file !== basename($source_file)) {
        
            $include_file_line = "include_once(BH_INCLUDE_PATH. \"$include_file\")";
            $include_file_line_preg = preg_quote($include_file_line, "/");

            if (preg_match("/$include_file_line_preg/", $source_file_contents) < 1) {

                $function_name_preg = preg_quote($function_name, "/");

                if (preg_match("/[ |\.|,]{$function_name_preg}[ ]?\(?/", $source_file_contents) > 0) {

                    if (!in_array($include_file, $include_files_required_array)) {
                    
                        $include_files_required_array[] = $include_file;
                    }
                }
            }
        }
    }

    if (sizeof($include_files_required_array) > 0) {

        asort($include_files_required_array);
        
        echo "\n\n$source_file\n", str_repeat("-", strlen($source_file)), "\n";
        echo "include_once(BH_INCLUDE_PATH. \"";
        echo implode("\");\ninclude_once(BH_INCLUDE_PATH. \"", $include_files_required_array);
        echo "\");\n";
    }
}
        
?>