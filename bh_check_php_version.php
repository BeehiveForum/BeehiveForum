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

/* $Id: bh_check_php_version.php,v 1.7 2008-05-11 13:01:09 decoyduck Exp $ */

// Requires PHP PEAR to be installed and PHP_CompatInfo Class.
// See: http://www.laurent-laville.org/index.php?module=pear&desc=pci

require_once 'PHP/CompatInfo.php';

// Set some options

$options = array('debug'            => false,  // Debug mode
                 'recurse_dir'      => true,  // Recurse all directories below 'forum'
                 'ignore_constants' => array('E_STRICT'), // Ignored PHP 5 constant used by errorhandler.inc.php
                 'ignore_functions' => array('sys_get_temp_dir', 'file_put_contents'), // Ignore these functions.
                 'ignore_dirs'      => array('forum\geshi', '.\forum\tiny_mce'),     // Ignore Geshi and TinyMCE
                 'ignore_files'     => array('forum\include\db\db_mysql.inc.php',    // Ignore our DB connection scripts.
                                             'forum\include\db\db_mysqli.inc.php')); // We know these work on PHP4.

// Tell the user what we're doing.

echo "Please wait checking Minimum PHP Version...\n\n";

// Check the version

$pci = new PHP_CompatInfo();
$res = $pci->parseFolder('forum', $options);

// Output the results.

echo sprintf("PHP Minimum Version = %s\nExtensions required : %s\n\n", $res['version'], implode(", ", $res['extensions']));

?>