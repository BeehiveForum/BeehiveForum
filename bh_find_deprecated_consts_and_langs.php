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

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "./forum/include/");

include_once(BH_INCLUDE_PATH. "constants.inc.php");

// Load Language File Function

function load_language_file($filename)
{
    $lang = array();

    include("./forum/include/languages/$filename");

    return $lang;
}

function get_files(&$files_array, $path, $ignore_files_array = array())
{
    if (!is_array($files_array)) $files_array = array();

    if (!is_array($ignore_files_array)) $ignore_files_array = array();

    if (($dir = opendir($path))) {

        while (($file = readdir($dir)) !== false) {

            if ($file != "." && $file != "..") {

                if (!is_dir("$path/$file")) {

                    $path_parts = pathinfo("$path/$file");

                    if (isset($path_parts['extension']) && $path_parts['extension'] == 'php') {

                        if (!in_array($file, $ignore_files_array)) {

                            $files_array[] = "$path/$file";
                        }
                    }
                }
            }
        }

        closedir($dir);
        return true;
    }
    
    return false;
}

@set_time_limit(0);

$unused_constants = get_defined_constants(true);

$unused_constants = isset($unused_constants['user']) ? $unused_constants['user'] : array();

$unused_langs = load_language_file("en.inc.php");

if (get_files($files_array, "forum")) {

    if (get_files($files_array, "forum/include", array('constants.inc.php'))) {

        if (get_files($files_array, "forum/include/db")) {

            echo "Please wait, checking files...\n\n";

            foreach ($files_array as $filename) {

                if (($file_contents = file_get_contents($filename))) {

                    echo "CHECKING: $filename\n";

                    foreach ($unused_langs as $lang_key => $lang_value) {

                        if (stristr($file_contents, "\$lang['$lang_key']")) {
                            unset($unused_langs[$lang_key]);
                        }
                    }

                    if (isset($unused_constants) && is_array($unused_constants)) {

                        foreach ($unused_constants as $const_key => $const_value) {

                            if (stristr($file_contents, $const_key)) {
                                unset($unused_constants[$const_key]);
                            }
                        }
                    }

                }else {

                    echo "FAILED TO LOAD: $filename\n";
                }
            }

            if (sizeof($unused_langs) > 0) {

                echo "\nUnused language strings:\n\n";

                foreach ($unused_langs as $lang_key => $lang_value) {

                    echo "\$lang['$lang_key'] = \"$lang_value\";\n";
                }

            }else {

                echo "\nNo unused language strings detected!\n";
            }

            if (sizeof($unused_constants) > 0) {

                echo "\nUnused Constants:\n\n";

                foreach ($unused_constants as $const_key => $const_value) {

                    echo "define(\"$const_key\", $const_value);\n";
                }

            }else {

                echo "\nNo unused constants detected!\n";
            }
        }
    }
}

?>