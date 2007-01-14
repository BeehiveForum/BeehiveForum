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

/* $Id: bh_check_dependencies.php,v 1.14 2007-01-14 21:04:49 decoyduck Exp $ */

$include_files_dir   = "forum/include";
$include_files_array = array("\$lang" => "lang.inc.php");

$source_files_dir_array = array("forum", "forum/include");
$source_files_array     = array();

$excl_include_files_array = array("htmltools.inc.php", "zip_lib.inc.php", "lang.inc.php");

echo "Getting list of functions...\n";

if (is_dir($include_files_dir)) {

    if ($dir = opendir($include_files_dir)) {

        while (($file = readdir($dir)) !== false) {

            if (!in_array($file, $excl_include_files_array)) {
            
                $pathinfo = pathinfo("$include_files_dir/$file");

                if (isset($pathinfo['extension']) && $pathinfo['extension'] == 'php') {

                    $file_contents[$file] = file_get_contents("$include_files_dir/$file");

                    if (preg_match_all("/function\s([a-z1-9-_]+)[\s]?\(/i", $file_contents[$file], $function_matches)) {

                        for ($i = 0; $i < sizeof($function_matches[1]); $i++) {

                            $include_files_array[$function_matches[1][$i]] = $file;
                        }
                    }

                    if (preg_match_all("/define[ ]?\([\"|']?([a-z1-9-_]+)/i", $file_contents[$file], $function_matches)) {

                        for ($i = 0; $i < sizeof($function_matches[1]); $i++) {

                            $include_files_array[$function_matches[1][$i]] = $file;
                        }
                    }
                }
            }
        }
    }
}

foreach($source_files_dir_array as $source_files_dir) {

    if (is_dir($source_files_dir)) {

        if ($dir = opendir($source_files_dir)) {

            while (($file = readdir($dir)) !== false) {

                $pathinfo = pathinfo("$source_files_dir/$file");

                if (isset($pathinfo['extension']) && $pathinfo['extension'] == 'php') {

                    echo "Checking $source_files_dir/$file for function matches...\n";
                    
                    $file_contents[$file] = file_get_contents("$source_files_dir/$file");
                    $file_include_array[$file] = array();

                    foreach ($include_files_array as $function_name => $include_file) {

                        if ($include_file != $file) {

                            $include_file_line = "include_once(BH_INCLUDE_PATH. \"$include_file\")";
                            $function_name_preg = preg_quote($function_name, "/");

                            if (!stristr($file_contents[$file], $include_file_line)) {

                                if (preg_match("/[ |\.|,]{$function_name_preg}[ ]?\(/", $file_contents[$file])) {

                                    if (!isset($file_include_array[$file][$include_file])) {

                                        $file_include_array[$file][$include_file] = array($function_name);
                                    
                                    }else if (!in_array($function_name, array_values($file_include_array[$file][$include_file]))) {

                                        $file_include_array[$file][$include_file][] = $function_name;
                                    }
                                }
                            }

                            $include_file_line = "include_once(BH_INCLUDE_PATH. \"lang.inc.php\")";

                            if (!stristr($file_contents[$file], $include_file_line)) {

                                if (preg_match('/\$lang/i', $file_contents[$file])) {

                                    if (!isset($file_include_array[$file]['lang.inc.php'])) {

                                        $file_include_array[$file]['lang.inc.php'] = array('$lang');
                                    
                                    }else if (!in_array($function_name, array_values($file_include_array[$file]['lang.inc.php']))) {

                                        $file_include_array[$file]['lang.inc.php'][] = $function_name;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}

foreach ($file_include_array as $filename => $include_file_array) {

    $display_file_name = false;

    foreach ($include_file_array as $include_file => $function_name_array) {

        if (sizeof($function_name_array) > 0) {

            if ($display_file_name === false) {

                asort($function_name_array);

                $function_name_list = implode(", ", $function_name_array);

                echo "\n\n$filename\n", str_repeat("-=", strlen($filename) / 2), "\n";
                echo "Uses: $function_name_list\n\n";
                $display_file_name = true;
            }

            echo "include_once(BH_INCLUDE_PATH. \"$include_file\");\n";
        }
    }
}

?>