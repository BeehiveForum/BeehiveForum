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

/* $Id: bh_update_language.php,v 1.17 2008-08-06 23:09:29 decoyduck Exp $ */

// Constant to define where the include files are

define("BH_INCLUDE_PATH", "./forum/include/");

include_once(BH_INCLUDE_PATH. "format.inc.php");

// Get our target language file.

if (isset($_SERVER['argv'][1]) && strlen(trim(_stripslashes($_SERVER['argv'][1]))) > 0) {

    $target_language_file = trim(_stripslashes($_SERVER['argv'][1]));

    if (!$lang_fix = file(BH_INCLUDE_PATH. "/languages/$target_language_file")) {

        echo "Failed to load language file ($target_language_file). Check working directory and filename\n";
        exit;
    }

}else {

    echo "No target language file specified";
    exit;
}

// Get our optional updates file

if (isset($_SERVER['argv'][2]) && strlen(trim(_stripslashes($_SERVER['argv'][2]))) > 0) {

    $additions_file = trim(_stripslashes($_SERVER['argv'][2]));

    if (!$lang_add = file(BH_INCLUDE_PATH. "/languages/$additions_file")) {

        $lang_add = array();
    }

}else {

    $lang_add = array();
}

if (@file_exists(BH_INCLUDE_PATH. "languages/en.inc.php")) {

    $lang_en = file(BH_INCLUDE_PATH. "languages/en.inc.php");

    foreach ($lang_en as $lang_en_line) {

        $lang_en_line = trim($lang_en_line);

        $line_matched = false;

        $lang_matches = array();

        if (preg_match('/^\$lang((\[[^\]]+\])+)/i', $lang_en_line, $lang_matches)) {

            foreach ($lang_add as $lang_add_line) {

                $lang_add_line = trim($lang_add_line);

                $preg_lang_add_match = preg_quote("\$lang{$lang_matches[1]}", "/");

                $lang_add_matches = array();

                if (preg_match("/^{$preg_lang_add_match}[^\"]+\"(.+)\";?/i", $lang_add_line, $lang_add_matches)) {

                    if (isset($lang_add_matches[1]) && strlen(trim($lang_add_matches[1])) > 0) {

                        echo "\$lang{$lang_matches[1]} = \"{$lang_add_matches[1]}\";\n";
                        $line_matched = true;
                        break;
                    }
                }
            }

            if ($line_matched === false) {

                foreach ($lang_fix as $lang_fix_line) {

                    $lang_fix_line = trim($lang_fix_line);

                    $preg_lang_fix_match = preg_quote("\$lang{$lang_matches[1]}", "/");

                    $lang_fix_matches = array();

                    if (preg_match("/^{$preg_lang_fix_match}[^\"]+\"(.+)\";?/i", $lang_fix_line, $lang_fix_matches)) {

                        if (isset($lang_fix_matches[1]) && strlen(trim($lang_fix_matches[1])) > 0) {

                            echo "\$lang{$lang_matches[1]} = \"{$lang_fix_matches[1]}\";\n";
                            $line_matched = true;
                            break;
                        }
                    }
                }
            }

        }else {

            echo "$lang_en_line\n";
            $line_matched = true;
        }
    }

}else {

    echo "Failed to load English language file (en.inc.php). Check working directory and filename";
    exit;
}

?>