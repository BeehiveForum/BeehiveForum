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

// Requires PHP PEAR to be installed and PHP_CompatInfo Class.
// See: http://www.laurent-laville.org/index.php?module=pear&desc=pci
require_once 'PHP/CompatInfo.php';

// Prevent time out
set_time_limit(0);

// Output the content as text.
header('Content-Type: text/plain');

// Tell the user what we're doing.
echo "Please wait checking Minimum PHP Version...\n\n";

// Instantiate PHP_CompatInfo with null renderer.
$pci = new PHP_CompatInfo('null');

// Array to store extracted per-file version info.
$versions_array = array();

// Array of keys to ignore in result array.
$ignore_result_keys = array(
    'ignored_files',
    'ignored_functions',
    'ignored_extensions',
    'ignored_constants',
    'max_version',
    'version',
    'classes',
    'functions',
    'extensions',
    'constants',
    'tokens',
    'cond_code'
);

// Check for command line arguments to individual files.
if (isset($_SERVER['argc']) && ($_SERVER['argc'] > 1)) {

    // Parse the specified files only.
    $results = $pci->parseArray(array_splice($_SERVER['argv'], 1));

} else {

    // Set some options
    $options = array(
        'debug'       => false,
        'recurse_dir' => true,
        'ignore_dirs' => array(
            'forum/include/languages',
            'forum/include/swift',
            'forum/geshi',
            'forum/tiny_mce'
        ),
    );

    // Parse the forum directory.
    $results = $pci->parseFolder('forum', $options);
}

// Output the results.
printf("PHP Minimum Version = %s\nExtensions required : %s\n\n", $results['version'], implode(", ", $results['extensions']));

// Iterate over the result array.
foreach ($results as $script_filename => $version_info) {

    // Ignore keys in the ignore_result_keys array.
    if (!in_array($script_filename, $ignore_result_keys) && isset($version_info['version'])) {

        // If the version info contains a version key, add it to $versions_array.
        $versions_array[$version_info['version']][] = $script_filename;
    }
}

ksort($versions_array);

// Display the filenames grouped by version.
foreach ($versions_array as $version => $script_filenames) {

    if (sizeof($script_filename) > 0) {

        printf("%s\n%s\n%s\n\n", $version, str_repeat('=', strlen($version)), implode("\n", $script_filenames));
    }
}

?>