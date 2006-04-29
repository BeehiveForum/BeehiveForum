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

/* $Id: bh_check_languages.php,v 1.23 2006-04-29 16:10:45 decoyduck Exp $ */

// Compare two language files.

function load_language_file($filename)
{
    include("./forum/include/languages/$filename");
    return $lang;
}

// Master Language File.

$master_lang = load_language_file("en.inc.php");

// Slave Language Files.

$slave_langs = array("en-us.inc.php"    => load_language_file("en-us.inc.php"),
                     "x-hacker.inc.php" => load_language_file("x-hacker.inc.php"),
                     "fr-ca.inc.php"    => load_language_file("fr-ca.inc.php"));

foreach ($slave_langs as $lang => $strings) {

    echo $lang, "\n", str_repeat("=", strlen($lang)), "\n\n";
    $errors = false;

    foreach ($master_lang as $key => $value) {

        if (!isset($strings[$key]) || $strings[$key] == $value) {

            echo "+\$lang['$key'] = \"$value\";\n";
            $errors = true;
        }
    }

    foreach ($strings as $key => $value) {

        if (!isset($master_lang[$key])) {

            echo "-\$lang['$key'] = \"$value\";\n";
            $errors = true;
        }
    }

    if (!$errors) echo "No errors found.\n";
    echo "\n\n";
}

?>