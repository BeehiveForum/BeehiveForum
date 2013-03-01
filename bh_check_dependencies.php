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

set_time_limit(0);

header('Content-Type: text/plain');

function preg_quote_callback($str)
{
    return preg_quote($str, "/");
}

$source_files_array = array();

$update_files_array = array();

$source_files_dir_array = array(
    'forum',
    'forum/include'
);

set_time_limit(0);

header('Content-Type: text/plain');

foreach ($source_files_dir_array as $include_file_dir) {

    if (!($dir = opendir($include_file_dir))) {
        continue;
    }

    while (($filename = readdir($dir)) !== false) {

        $path_info_array = pathinfo("$include_file_dir/$filename");

        if (!isset($path_info_array['extension']) || ($path_info_array['extension'] != 'php')) {
            continue;
        }

        $source_files_array["$include_file_dir/$filename"] = $filename;
    }
}

if (isset($_SERVER['argv'][1])) {

    if (!file_exists($_SERVER['argv'][1]) || !is_readable($_SERVER['argv'][1])) {

        echo "File '{$_SERVER['argv'][1]} does not exist or is not readable.\n\n";
        exit;
    }

    $update_files_array[$_SERVER['argv'][1]] = basename($_SERVER['argv'][1]);

} else {

    $update_files_array = $source_files_array;
}

ksort($update_files_array);

echo "Getting list of functions...\n";

foreach ($source_files_array as $source_file => $filename) {

    $source_file_contents = file_get_contents($source_file);

    $function_matches = array();

    $constant_matches = array();

    if (preg_match_all('/^function\s+([^\(]+)\(/imu', $source_file_contents, $function_matches)) {

        if (!isset($include_files_functions_array[$filename])) {
            $include_files_functions_array[$filename] = array();
        }

        foreach ($function_matches[1] as $function_match) {

            $include_files_functions_array[$filename][] = sprintf(
                '/(%1$s\s*\(|["|\']%1$s["|\'])/mu',
                preg_quote($function_match)
            );
        }
    }

    if (preg_match_all('/^(abstract\s*)?class\s*([A-Z_\x7f-\xff][A-Z0-9_\x7f-\xff]*)/imu', $source_file_contents, $class_matches)) {

        if (!isset($include_files_functions_array[$filename])) {
            $include_files_functions_array[$filename] = array();
        }

        foreach ($class_matches[2] as $class_match) {

            $include_files_functions_array[$filename][] = sprintf(
                '/(new %1$s\s*\(|%1$s::[^\(]+)/mu',
                preg_quote($class_match)
            );
        }
    }
}

ksort($include_files_functions_array);

echo "Updating files...\n\n";

foreach ($update_files_array as $source_file => $filename) {

    echo "Updating ", $source_file, "...\n";

    $source_file_contents = preg_replace(
        '/\/\/ Required includes.*\/\/ End Required includes/su',
        "// Required includes\n// End Required includes",
        file_get_contents($source_file)
    );

    $include_files_required_array = array(
        'constants.inc.php' => "require_once BH_INCLUDE_PATH. 'constants.inc.php'",
    );

    foreach ($include_files_functions_array as $include_file => $function_names_array) {

        if ($include_file == $filename) {
            continue;
        }

        $include_file_line = sprintf(
            "require_once BH_INCLUDE_PATH. '%s'",
            $include_file
        );

        $include_file_line_preg = sprintf(
            "/%s/mu",
            preg_quote($include_file_line)
        );

        if (preg_match($include_file_line_preg, $source_file_contents) > 0) {
            continue;
        }

        foreach ($function_names_array as $function_name_preg) {

            if (preg_match_all($function_name_preg, $source_file_contents) > 0) {
                $include_files_required_array[$include_file] = $include_file_line;
            }
        }
    }

    ksort($include_files_required_array);

    $required_includes_lines = sprintf(
        "// Required includes\n%s;\n// End Required includes",
        implode(";\n", $include_files_required_array)
    );

    file_put_contents(
        $source_file,
        preg_replace(
            '/\/\/ Required includes.*\/\/ End Required includes/su',
            $required_includes_lines,
            $source_file_contents
        )
    );
}

?>