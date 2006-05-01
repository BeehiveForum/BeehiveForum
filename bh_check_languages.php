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

/* $Id: bh_check_languages.php,v 1.24 2006-05-01 18:30:10 decoyduck Exp $ */

// Compare two language files.

function load_language_file($filename)
{
    include("./forum/include/languages/$filename");
    return $lang;
}

// Makes lang data human readable.

function parse_lang_data($key, $data, $prefix)
{
    if (is_array($data)) {

        foreach($data as $array_key => $array_data) {

            if (is_string($key)) {
                parse_lang_data($array_key, $array_data, "{$prefix}['$key']");
            }else {
                parse_lang_data($array_key, $array_data, "{$prefix}[$key]");
            }
        }

    }else {

        if (!preg_match("/^_/", $key)) {
       
            if (is_string($key)) {
                echo "{$prefix}['$key'] = \"$data\";\n";
            }else {
                echo "{$prefix}[$key] = \"$data\";\n";
            }
        }
    }
}

// Master Language File.

$master_lang = load_language_file("en.inc.php");

// Slave Language Files.

$slave_langs = array("en-us.inc.php"    => array('lang' => load_language_file("en-us.inc.php"), 'showut' => false),
                     "x-hacker.inc.php" => array('lang' => load_language_file("x-hacker.inc.php"), 'showut' => true),
                     "fr-ca.inc.php"    => array('lang' => load_language_file("fr-ca.inc.php"), 'showut' => true));

foreach ($slave_langs as $lang_name => $slave_lang) {

    if (isset($slave_lang['lang']) && is_array($slave_lang['lang'])) {
    
        echo $lang_name, "\n", str_repeat("=", strlen($lang_name)), "\n\n";

        $strings = $slave_lang['lang'];
        $errors = false;

        foreach ($master_lang as $key => $value) {

            if (!isset($strings[$key])) {

                parse_lang_data($key, $value, '+$lang');
                $errors = true;

            }elseif (($strings[$key] == $value) && ($slave_lang['showut'] === true)) {

                parse_lang_data($key, $value, '=$lang');
                $errors = true;
            }
        }

        foreach ($strings as $key => $value) {

            if (!isset($master_lang[$key])) {

                parse_lang_data($key, $value, '-$lang');
                $errors = true;
            }
        }

        if (!$errors) echo "No errors found.\n";
        echo "\n\n";
    }
}

?>