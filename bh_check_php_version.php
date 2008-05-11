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

/* $Id: bh_check_php_version.php,v 1.6 2008-05-11 09:31:04 decoyduck Exp $ */

// Requires PHP PEAR to be installed and PHP_CompatInfo Class.
// See: http://www.laurent-laville.org/index.php?module=pear&desc=pci

require_once 'PHP/CompatInfo.php';

// Directory to work in.

$dir = dirname('.\forum');

// Set some options

$options = array('debug'            => false,  // Debug mode
                 'recurse_dir'      => true,  // Recurse all directories below 'forum'
                 'ignore_functions' => array('sys_get_temp_dir', 'file_put_contents'), // Ignore these functions.
                 'ignore_dirs'      => array('.\forum\geshi', '.\forum\tiny_mce'), // Ignore Geshi and TinyMCE
                 'ignore_files'     => array('.\forum\include\db\db_mysql.inc.php',    // Ignore our DB connection scripts.
                                             '.\forum\include\db\db_mysqli.inc.php',  // We know these work on PHP4.
                                             '.\bh_check_dependencies.php',            // Support scripts which we don't distribute
                                             '.\bh_check_languages.php',
                                             '.\bh_check_php_version.php',
                                             '.\bh_check_styles.php',
                                             '.\bh_cvs_log_parse.php',
                                             '.\bh_cvs_log_parse_exclude.php',
                                             '.\bh_find_deprecated_consts_and_langs.php',
                                             '.\bh_find_undefined_language_strings.php',
                                             '.\bh_ms_word_spelling_check.php',
                                             '.\bh_update_language.php',
                                             '.\bh_x-hacker_translate.php',
                                             '.\userdb_beehive.php'));

// Tell the user what we're doing.

echo "Please wait checking Minimum PHP Version...\n\n";

// Check the version

$pci = new PHP_CompatInfo();
$res = $pci->parseFolder($dir, $options);

// Output the results.

echo sprintf("PHP Minimum Version = %s\nExtensions required : %s\n\n", $res['version'], implode(", ", $res['extensions']));

echo sprintf("DEBUG Output:\n\n%s", print_r($res, true));

?>