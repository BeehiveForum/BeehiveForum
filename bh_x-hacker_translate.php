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

/* $Id: bh_x-hacker_translate.php,v 1.5 2003-08-31 16:21:05 hodcroftcj Exp $ */

// Creates an X-Hacker (L33t SpEak) language file from the en.inc.php
// Derived from the L33t-5p34K G3n3r@t0r v3r510N 0.6 found at :
// http://www.geocities.com/mnstr_2000/translate.html

// Outputs to STDOUT.

function rn($r) {
    srand((double)microtime()*1000000);
    return rand(1, $r);
}

function translate($string) {

    $string_parts = preg_split('/([<|>])/', $string, -1, PREG_SPLIT_DELIM_CAPTURE);

    // Process Specific Words

    for ($i = 0; $i < sizeof($string_parts); $i++) {

        if (!($i % 4)) {

            $str_words = explode(' ', strtolower($string_parts[$i]));

            for ($j = 0; $j < sizeof($str_words); $j++) {

                $str_word = $str_words[$j];

                if ($str_word == "am" && $str_words[$i + 1] == "good") {
                    $str_word = "ownz0r";
                    $i++;
                }

                if ($str_word == "is" && $str_words[$i + 1] == "good") {
                    $str_word = "ownz0rz";
                    $i++;
                }

                if ($str_word == "the" && rn(10) > 6) $str_word = "teh";
                if ($str_word == "you") $str_word = "j00";

                $str_translated = $str_translated. $str_word. " ";
            }

        }else {

            $str_translated = $str_translated. trim($string_parts[$i]);

        }
    }

    $string_parts = preg_split('/([<|>])/', $str_translated, -1, PREG_SPLIT_DELIM_CAPTURE);

    //Process Individual Chars

    for ($i = 0; $i < sizeof($string_parts); $i++) {

        if (!($i % 4)) {

            for ($j = 0; $j < strlen($string_parts[$i]); $j++) {

                $char = substr($string_parts[$i], $j, 1);

                if ($char == "a" && rn(10) > 7) $char = "@";
                if ($char == "a" && rn(10) > 2) $char = "4";
                if ($char == "b" && rn(10) > 5) $char = "8";
                if ($char == "d" && rn(10) > 10) $char = "|)";
                if ($char == "e" && rn(10) > 5) $char = "3";
                if ($char == "f" && rn(10) > 5) $char = "ph";
                if ($char == "g" && rn(10) > 5) $char = "9";
                if ($char == "h" && rn(10) > 10) $char = "|-|";
                if ($char == "i" && rn(10) > 5) $char = "1";
                if ($char == "k" && rn(10) > 10) $char = "|&gt;";
                if ($char == "m" && rn(10) > 10) $char = "|\/|";
                if ($char == "n" && rn(10) > 10) $char = "|\|";
                if ($char == "o" && rn(10) > 5) $char = "0";

                if ($char == "q" && $string_parts[$i + 1] == "u") {
                    $char = "kw";
                    $i++;
                }

                if ($char == "s" && rn(10) > 7) $char = "\\$";
                if ($char == "s" && rn(10) > 7) $char = "5";
                if ($char == "t" && rn(10) > 5) $char = "+";
                if ($char == "v" && rn(10) > 10) $char = "\/";
                if ($char == "w" && rn(10) > 10) $char = "\/\/";
                if ($char == "x" && rn(10) > 10) $char = "&gt;&lt;";

                $string_new = $string_new. $char;
            }

        }else {

            $string_new = $string_new. $string_parts[$i];
        }
    }

    // Randomize case

    $string_parts = preg_split('/([<|>])/', $string_new, -1, PREG_SPLIT_DELIM_CAPTURE);

    for ($i = 0; $i < sizeof($string_parts); $i++) {

        if (!($i % 4)) {

            for ($j = 0; $j < strlen($string_parts[$i]); $j++) {

                $char = substr($string_parts[$i], $j, 1);

                if (rn(10) > 5) $char = strtoupper($char);
                $str_out = $str_out. $char;

            }

        }else {

            $str_out = $str_out. $string_parts[$i];

        }
    }

    return trim(str_replace(' <', '<', $str_out));
}

// Start here

if ($langfile = file('./forum/include/languages/en.inc.php')) {
    if ($fp = fopen('./forum/include/languages/x-hacker.inc.php', 'w')) {
        foreach($langfile as $line) {
            if (preg_match('/\$lang\[\'(.*)\'\] = "(.*)";/', $line, $value)) {
                if (substr($value[1], 0, 1) != "_") {
                    $value[2] = translate($value[2]);
                }
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
