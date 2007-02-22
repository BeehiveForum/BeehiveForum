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

/* $Id: bh_update_language.php,v 1.3 2007-02-22 21:38:02 decoyduck Exp $ */

// Constant to define where the include files are //

define("BH_INCLUDE_PATH", "./forum/include/");

// Function to load BH language file into $lang array //

function load_language_file($filename)
{
    if (file_exists(BH_INCLUDE_PATH. "languages/$filename")) {
    
        include(BH_INCLUDE_PATH. "languages/$filename");
        return $lang;
    }

    return false;
}

// Checks for Magic Quotes and perform stripslashes if nessecary //

function _stripslashes($string)
{
    if (get_magic_quotes_gpc() == 1) {
        return stripslashes($string);
    }else {
        return $string;
    }
}

// Start here //

$valid = true;

if (isset($_SERVER['argv'][1]) && strlen(trim(_stripslashes($_SERVER['argv'][1])))) {

    $target_language_file = trim(_stripslashes($_SERVER['argv'][1]));

    if (!$lang_fix = load_language_file($target_language_file)) {
        
        echo "Failed to load language file. Check working directory and filename.\n";
        exit;
    }

}else {

    echo "No target language file specified.\n";
    exit;
}

if (isset($_SERVER['argv'][2]) && strlen(trim(_stripslashes($_SERVER['argv'][2])))) {

    $additions_file = trim(_stripslashes($_SERVER['argv'][2]));

    if (!$lang_add = load_language_file($additions_file)) {

        echo "Failed to load additions file. Check working directory and filename.\n";
        exit;
    }

}else {

    echo "No additions file specified.\n";
    exit;
}

if (file_exists(BH_INCLUDE_PATH. "languages/en.inc.php")) {

    $lang_en = file(BH_INCLUDE_PATH. "languages/en.inc.php");

    foreach ($lang_en as $line_num => $lang_en_line) {

        $lang_en_line = trim($lang_en_line);
        
        if (preg_match("/^\\\$lang((\[[^\]]+\])+)/", $lang_en_line, $lang_matches)) {

            $php_code = "if (isset(\$lang_add{$lang_matches[1]})) {";
            $php_code.= "echo \"\\\$lang{$lang_matches[1]} = \\\"\", ";
            $php_code.= "addcslashes(\$lang_add{$lang_matches[1]}, \"\\\$\\\"\"), \"\\\";\n\";";
            $php_code.= "}elseif (isset(\$lang_fix{$lang_matches[1]})) {";
            $php_code.= "echo \"\\\$lang{$lang_matches[1]} = \\\"\", ";
            $php_code.= "addcslashes(\$lang_fix{$lang_matches[1]}, \"\\\$\\\"\"), \"\\\";\n\";";
            $php_code.= "}";

            eval($php_code);

        }else {

            echo "$lang_en_line\n";
        }
    }

}else {

    echo "Failed to load English language file. Check working directory and filename.\n";
}

?>