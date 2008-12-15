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

/* $Id: bh_check_php_version.php,v 1.11 2008-12-15 21:18:09 decoyduck Exp $ */

// Requires PHP PEAR to be installed and PHP_CompatInfo Class.
// See: http://www.laurent-laville.org/index.php?module=pear&desc=pci

require_once 'PHP/CompatInfo.php';

// Set some options

$options = array('debug'            => false,  // Debug mode
                 'recurse_dir'      => true,  // Recurse all directories below 'forum'
                 'ignore_dirs'      => array('forum\geshi', 'forum\tiny_mce'),  // Ignore Geshi and TinyMCE
                 'ignore_functions' => array('sys_get_temp_dir', 'file_put_contents', 'array_combine')); // Ignore these functions

// Tell the user what we're doing.

echo "Please wait checking Minimum PHP Version...\n\n";

// Check the version

$pci = new PHP_CompatInfo('null');
$res = $pci->parseFolder('forum', $options);

print_r($res);

// Output the results.

echo sprintf("PHP Minimum Version = %s\nExtensions required : %s\n\n", $res['version'], implode(", ", $res['extensions']));

?>