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

require 'Bartlett/PHP/CompatInfo/Autoload.php';
require 'Bartlett/PHP/CompatInfo.php';

set_time_limit(0);

header('Content-Type: text/plain');

echo "Please wait checking Minimum PHP Version...\n\n";

$pci = new PHP_CompatInfo();

$minimum_version = "0";

$versions_array = array();

$extensions_array = array();

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

if (isset($_SERVER['argc']) && ($_SERVER['argc'] > 1)) {

    $pci->parse(array_splice($_SERVER['argv'], 1));

} else {

    $options = array(
        'debug' => false,
        'recurse_dir' => true,
        'ignore_dirs' => array(
            'forum/include/languages',
            'forum/include/swift',
            'forum/tiny_mce'
        ),
    );

    $pci->parse('forum');
}

$results = $pci->toArray();

foreach ($results['extensions'] as $extension_name => $extension_info) {

    if (in_array($extension_name, array('Core', 'standard'))) {
        continue;
    }

    $extensions_array[] = $extension_name;
}

$minimum_version = $results['versions'][0];

sort($extensions_array);

printf(
    "PHP Minimum Version = %s\nExtensions required : %s\n\n",
    $minimum_version,
    implode(", ", $extensions_array)
);

?>