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

/* $Id: bh_check_dependencies.php,v 1.7 2004-04-24 18:42:15 decoyduck Exp $ */

$include_files_dir   = "forum/include";
$include_files_array = array("\$lang" => "lang.inc.php");

$source_files_dir_array = array("forum", "forum/include");
$source_files_array     = array();

$excl_include_files_array = array("gzipenc.inc.php", "forum.inc.php", "errorhandler.inc.php");

if (is_dir($include_files_dir)) {
    if ($dir = opendir($include_files_dir)) {
        while (($file = readdir($dir)) !== false) {
            $pathinfo = pathinfo("$include_files_dir/$file");
            if ($pathinfo['extension'] == 'php') {
                $file_contents = file_get_contents("$include_files_dir/$file");
                if (preg_match_all("/function\s([a-z1-9-_]+)[\s]?\(/i", $file_contents, $function_matches)) {
                    for ($i = 0; $i < sizeof($function_matches[1]); $i++) {
                        $include_files_array[$function_matches[1][$i]] = $file;
                    }
                }
                if (preg_match_all("/define[ ]?\([\"|']?([a-z1-9-_]+)/i", $file_contents, $function_matches)) {
                    for ($i = 0; $i < sizeof($function_matches[1]); $i++) {
                        $include_files_array[$function_matches[1][$i]] = $file;
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
                if ($pathinfo['extension'] == 'php') {
                    $file_contents = file_get_contents("$source_files_dir/$file");
                    $file_include_array[$file] = array();
                    foreach ($include_files_array as $function_name => $include_file) {
                        $include_file_preg = preg_quote($include_file, "/");
                        if (!in_array($include_file, $file_include_array[$file]) && !in_array($include_file, $excl_include_files_array) && $include_file != $file) {
                            if (preg_match("/$include_file_preg/i", $file_contents)) {
                                $file_include_array[$file][] = $include_file;
                            }
                        }
                        if (!in_array("lang.inc.php", $file_include_array[$file]) && !in_array("lang.inc.php", $excl_include_files_array) && "lang.inc.php" != $file) {
                            if (preg_match("/\\\$lang/", $file_contents)) {
                                $file_include_array[$file][] = "lang.inc.php";
                            }
                        }
                    }
                }
            }
        }
    }
}

foreach($file_include_array as $filename => $include_array) {
    if (is_array($include_array) && sizeof($include_array) > 0) {
        echo " === $filename ===\n\n";
        sort($include_array);
        foreach ($include_array as $include_file) {
            echo "include_once(\"./include/$include_file\");\n";
        }
        echo "\n\n";
    }
}

?>