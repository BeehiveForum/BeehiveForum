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

/* $Id: bh_find_deprecated_consts_and_langs.php,v 1.1 2006-07-28 17:48:40 decoyduck Exp $ */

// Constant to define where the include files are
define("BH_INCLUDE_PATH", "./forum/include/");

include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");

function get_files($path, &$files_array)
{
    if (!is_array($files_array)) return false;

    if ($dir = opendir($path)) {

        while (($file = readdir($dir)) !== false) {

            if ($file != "." && $file != "..") {

                if (!is_dir("$path/$file")) {

                    $path_parts = pathinfo("$path/$file");

                    if (isset($path_parts['extension']) && $path_parts['extension'] == 'php') {

                        $files_array[] = "$path/$file";
                    }
                }
            }
        }

        closedir($dir);
        return true;
    }
}

set_time_limit(0);

$files_array = array();
$deprecated_array = array();
$unused_langs = array();

$defined_constants = get_defined_constants(true);
$unused_constants = $defined_constants;

$lang = load_language_file("en.inc.php");
$unused_langs = $lang;

if (get_files("./forum", $files_array)) {

    if (get_files("./forum/include", $files_array)) {

        echo "Please wait, checking files...\n\n";

        foreach($files_array as $filename) {

            if ($file_contents = file_get_contents($filename)) {

                echo "CHECKING: $filename\n";

                reset($lang);

                foreach($lang as $lang_key => $lang_value) {

                    if (stristr($file_contents, "\$lang['$lang_key']")) {
                        unset($unused_langs[$lang_key]);
                    }
                }

                if (isset($defined_constants['user']) && is_array($defined_constants['user'])) {

                    foreach($defined_constants['user'] as $const_key => $const_value) {

                        if (stristr($file_contents, $const_key)) {
                            unset($unused_constants['user'][$const_key]);
                        }
                    }
                }

            }else {

                echo "FAILED TO LOAD: $filename\n";
            }
        }

        if (sizeof($unused_langs) > 0) {

            echo "\nUnused language strings:\n\n";

            foreach($unused_langs as $lang_key => $lang_value) {

                echo "\$lang['$lang_key'] = \"$lang_value\";\n";
            }

        }else {

            echo "\nNo unused language strings detected!\n";
        }

        if (isset($defined_constants['user']) && is_array($defined_constants['user'])) {

            if (sizeof($unused_constants['user']) > 0) {

                echo "\nUnused Constants:\n\n";

                foreach($unused_constants['user'] as $const_key => $const_value) {

                    echo "define(\"$const_key\", $const_value);\n";
                }

            }else {

                echo "\nNo unused constants detected!\n";
            }
        }
    }
}

?>