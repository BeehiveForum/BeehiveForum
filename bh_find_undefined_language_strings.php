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

define("BH_INCLUDE_PATH", "forum/include/");

$exclude_files_array = array();

$exclude_dirs_array = array('forum/include/languages', 'forum/include/swift');

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

                }else if ((preg_match("/$extension_preg$/iu", $file_name) > 0) && !in_array("$path/$file_name", $GLOBALS['exclude_files_array'])) {

                    $file_list_array[] = "$path/$file_name";
                }
            }
        }
    }

    return sizeof($file_list_array) > 0;
}

set_time_limit(0);

header('Content-Type: text/plain');

if (($lang = get_language_file('en.inc.php'))) {

    if (get_file_list($file_list_array, 'forum', '.php')) {

        foreach ($file_list_array as $file_path_name) {

            if (!($file_contents = @file_get_contents($file_path_name))) {
                continue;
            }

            $lang_matches = array();

            if (!preg_match_all('/\$lang\[\'([^\']+)\'\]/iu', $file_contents, $lang_matches) > 0) {
                continue;
            }

            $lang_matches = array_unique($lang_matches[1]);

            foreach ($lang_matches as $lang_key) {

                if (isset($lang[$lang_key])) {
                    continue;
                }

                echo "\$lang['$lang_key'] = \"\";\n";
            }
        }
    }
}

?>