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

// Creates an X-Hacker (L33t SpEak) language file from the en.inc.php
// Derived from the L33t-5p34K G3n3r@t0r v3r510N 0.6 found at :
// http://www.geocities.com/mnstr_2000/translate.html

// Outputs to STDOUT.

function rn($r) {
    srand((double)microtime()*1000000);
    return rand(1, $r);
}

function translate($string) {

    $string = strtolower($string);
    $stringArray = explode(' ', $string);

    // Process Words

    for ($i = 0; $i < sizeof($stringArray); $i++) {

        $strword = $stringArray[$i];

        if ($strword == "am" && $stringArray[$i + 1] == "good") {
            $strword = "ownz0r";
            $i++;
        }

        if ($strword == "is" && $stringArray[$i + 1] == "good") {
            $strword = "ownz0rz";
            $i++;
        }

        if ($strword == "the" && rn(10) > 6) $strword = "teh";
        if ($strword == "you") $strword = "j00";

        $strtranslated = $strtranslated. $strword. " ";
    }

    //Process Individual Chars

    for ($i = 0; $i < strlen($strtranslated); $i++) {

        $char = $strtranslated[$i];

        if ($char == "a" && rn(10) > 7) $char = "@";
        if ($char == "a" && rn(10) > 2) $char = "4";
        if ($char == "b" && rn(10) > 5) $char = "8";
        if ($char == "d" && rn(10) > 10) $char = "|)";
        if ($char == "e" && rn(10) > 5) $char = "3";
        if ($char == "f" && rn(10) > 5) $char = "ph";
        if ($char == "g" && rn(10) > 5) $char = "9";
        if ($char == "h" && rn(10) > 10) $char = "|-|";
        if ($char == "i" && rn(10) > 5) $char = "1";
        if ($char == "k" && rn(10) > 10) $char = "|<";
        if ($char == "m" && rn(10) > 10) $char = "|\/|";
        if ($char == "n" && rn(10) > 10) $char = "|\|";
        if ($char == "o" && rn(10) > 5) $char = "0";

        if ($char == "q" && $strtranslated[$i + 1] == "u") {
            $char = "kw";
            $i++;
        }

        if ($char == "s" && rn(10) > 7) $char = "$";
        if ($char == "s" && rn(10) > 2) $char = "5";
        if ($char == "t" && rn(10) > 5) $char = "+";
        if ($char == "v" && rn(10) > 10) $char = "\/";
        if ($char == "w" && rn(10) > 10) $char = "\/\/";
        if ($char == "x" && rn(10) > 10) $char = "><";

        $string_new = $string_new. $char;
    }

    // Randomize case

    for ($i = 0; $i < strlen($string_new); $i++) {

        $char = $string_new[$i];

        if (rn(10) > 5) $char = strtoupper($char);
        $str_out.= $char;

    }

    return trim($str_out);
}

// Start here

if ($langfile = file('./forum/include/languages/en.inc.php')) {
    if ($fp = fopen('./forum/include/languages/x-hacker.inc.php', 'w')) {
        foreach($langfile as $line) {
            if (preg_match('/\$lang\[\'(.*)\'\] = "(.*)";/', $line, $value)) {
                $value[2] = translate($value[2]);
                fwrite($fp, "\$lang['{$value[1]}'] = \"{$value[2]}\";\n");
            }else {
                fwrite($fp, $line);
            }
        }
        fclose($fp);
        echo "<p>Translation of ./forum/include/languages/en.inc.php completed successfully.</p>\n";
    }else {
        echo "<p>Could not open ./forum/include/languages/x-hacker.inc.php for writing.</p>\n";
    }
}else {
    echo "<p>Could not open ./forum/include/languages/en.inc.php for reading.</p>\n";
}

?>