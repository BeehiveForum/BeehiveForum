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

/* $Id: bh_update_language.php,v 1.1 2007-03-31 21:37:42 decoyduck Exp $ */

// Constant to define where the include files are //

define("BH_INCLUDE_PATH", "../include/");

// HTML output innit

include_once(BH_INCLUDE_PATH. "html.inc.php");

$valid = true;

if (isset($_GET['target']) && strlen(trim(_stripslashes($_GET['target']))) > 0) {

    $target_language_file = trim(_stripslashes($_GET['target']));
    
    if (!$lang_fix = file(BH_INCLUDE_PATH. "/languages/$target_language_file")) {
        
        html_draw_top();
        html_error_msg("<h1>Failed to load language file. Check working directory and filename</h1>\n");
        html_draw_bottom();
        exit;
    }

}else {

    html_draw_top();
    html_error_msg("<h1>No target language file specified</h1>");
    html_draw_bottom();
    exit;
}

if (isset($_GET['updates']) && strlen(trim(_stripslashes($_GET['updates']))) > 0) {

    $additions_file = trim(_stripslashes($_GET['updates']));

    if (!$lang_add = file(BH_INCLUDE_PATH. "/languages/$additions_file")) {

        html_draw_top();
        html_error_msg("<h1>Failed to load additions file. Check working directory and filename</h1>");
        html_draw_bottom();
        exit;
    }

}else {

    html_draw_top();
    html_error_msg("<h1>No additions file specified</h1>");
    html_draw_bottom();
    exit;
}

if (file_exists(BH_INCLUDE_PATH. "languages/en.inc.php")) {

    $lang_en = file(BH_INCLUDE_PATH. "languages/en.inc.php");

    $output_html = "";

    html_draw_top();

    foreach ($lang_en as $lang_en_line) {

        $lang_en_line = trim($lang_en_line);
        $line_matched = false;

        if (preg_match("/^\\\$lang((\[[^\]]+\])+)/i", $lang_en_line, $lang_matches)) {

            foreach ($lang_add as $lang_add_line) {

                $lang_add_line = trim($lang_add_line);

                $preg_lang_add_match = preg_quote("\$lang{$lang_matches[1]}", "/");

                if (preg_match("/^$preg_lang_add_match(.+)/i", $lang_add_line, $lang_add_matches)) {

                    $output_html.= "\$lang{$lang_matches[1]}{$lang_add_matches[1]}\n";
                    $line_matched = true;
                }
            }

            if ($line_matched === false) {

                foreach ($lang_fix as $lang_fix_line) {

                    $lang_fix_line = trim($lang_fix_line);

                    $preg_lang_fix_match = preg_quote("\$lang{$lang_matches[1]}", "/");

                    if (preg_match("/^$preg_lang_fix_match(.+)/i", $lang_fix_line, $lang_fix_matches)) {

                        $output_html.= "\$lang{$lang_matches[1]}{$lang_fix_matches[1]}\n";
                        $line_matched = true;
                    }
                }
            }
        }

        if ($line_matched === false) {

            $output_html.= "$lang_en_line\n";
        }
    }
    
    echo "<form name=\"f_email\" action=\"bh_update_language.php\" method=\"get\">\n";
    echo "  ", form_textarea('translation', _htmlentities($output_html), 40, 200), "\n";
    echo "</form>\n";

    html_draw_bottom();

}else {

    html_draw_top();
    html_error_msg("<h1>Failed to load English language file. Check working directory and filename</h1>");
    html_draw_bottom();
    exit;
}

?>