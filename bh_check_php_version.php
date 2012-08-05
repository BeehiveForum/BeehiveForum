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

// Requires PHP PEAR to be installed and Bartlett/PHP_CompatInfo.
// See: https://github.com/llaville/php-compat-info
require 'Bartlett/PHP/CompatInfo.php';
require 'Bartlett/PHP/CompatInfo/Autoload.php';

// Prevent time out
set_time_limit(0);

// Output the content as text.
header('Content-Type: text/plain');

// Tell the user what we're doing.
echo "Please wait checking Minimum PHP Version...\n\n";

// Instantiate PHP_CompatInfo with null renderer.
$pci = new PHP_CompatInfo();

// Minimum version required
$minimum_version = "0";

// Array to store extracted per-file version info.
$versions_array = array();

// Array to store extensions needed.
$extensions_array = array();

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
    $pci->parse(array_splice($_SERVER['argv'], 1));

} else {

    // Set some options
    $options = array(
        'debug' => false,
        'recurse_dir' => true,
        'ignore_dirs' => array(
            'forum/include/languages',
            'forum/include/swift',
            'forum/geshi',
            'forum/tiny_mce'
        ),
    );

    // Parse the forum directory.
    $pci->parse('forum');
}

// Fetch the results as an array
$results = $pci->toArray();    

// Iterate over the result array.
foreach ($results as $script_filename => $version_info) {

    if (!isset($versions_array[$version_info['versions'][0]])) {
        $versions_array[$version_info['versions'][0]] = array();
    }
    
    $versions_array[$version_info['versions'][0]][] = $script_filename;
    
    if (version_compare($version_info['versions'][0], $minimum_version, '>')) {
        $minimum_version = $version_info['versions'][0];
    }
    
    foreach ($version_info['extensions'] as $extension_name => $extension_info) {
        
        if (in_array($extension_name, array('Core', 'standard'))) {
            continue;
        }
        
        if (!isset($extensions_array[$extension_name][$extension_info['versions'][0]])) {
            $extensions_array[$extension_name][$extension_info['versions'][0]] = array();
        }
        
        $extensions_array[$extension_name][$extension_info['versions'][0]][] = $script_filename;
    }
}

// Sort the results
ksort($versions_array);

// Output the results.
printf("PHP Minimum Version = %s\nExtensions required : %s\n\n", $minimum_version, implode(", ", array_keys($extensions_array)));

// Display the filenames grouped by version.
foreach ($versions_array as $version => $script_filenames) {

    if (sizeof($script_filename) > 0) {

        printf("%s\n%s\n%s\n\n", $version, str_repeat('=', strlen($version)), implode("\n", $script_filenames));
    }
}

?>