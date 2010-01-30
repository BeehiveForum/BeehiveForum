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

/* $Id$ */

// Compare two language files.

function load_language_file($filename)
{
    $lang = array();

    include("./forum/include/languages/$filename");

    return $lang;
}

function compare_languages($master_lang, $slave_lang, $show_ut, $compare_method, $prefix, &$results_array)
{
    if (!is_array($results_array)) $results_array = array();

    if (strlen(trim($compare_method)) > 1) return false;

    if (is_array($master_lang)) {

        foreach ($master_lang as $master_lang_key => $master_lang_value) {

            if (is_array($master_lang_value)) {

                if (is_array($slave_lang) && isset($slave_lang[$master_lang_key])) {

                    if (is_string($master_lang_key)) {

                        compare_languages($master_lang_value, $slave_lang[$master_lang_key], $show_ut, $compare_method, "{$prefix}['$master_lang_key']", $results_array);

                    }else {

                        compare_languages($master_lang_value, $slave_lang[$master_lang_key], $show_ut, $compare_method, "{$prefix}[$master_lang_key]", $results_array);
                    }

                }else {

                    compare_languages($master_lang_value, array(), $show_ut, $compare_method, "{$prefix}['$master_lang_key']", $results_array);
                }

            }else {

                if (!is_array($slave_lang) || !isset($slave_lang[$master_lang_key])) {

                    $master_lang_value = addcslashes($master_lang_value, "\n\t\"\$");

                    if (preg_match('/\+|\-/u', $compare_method) > 0) {

                        if (is_string($master_lang_key)) {

                            $results_array[] = "{$prefix}['$master_lang_key'] = \"{$master_lang_value}\";";

                        }else {

                            $results_array[] = "{$prefix}[$master_lang_key] = \"{$master_lang_value}\";";
                        }
                    }

                }else if (($slave_lang[$master_lang_key] == $master_lang_value) && $show_ut == true) {

                    $master_lang_value = addcslashes($master_lang_value, "\n\t\"\$");

                    if ((preg_match("/^_/u", $master_lang_key) < 1) && (preg_match("/=/u", $compare_method) > 0)) {

                        if (is_string($master_lang_key)) {

                            $results_array[] = "{$prefix}['$master_lang_key'] = \"{$master_lang_value}\";";

                        }else {

                            $results_array[] = "{$prefix}[$master_lang_key] = \"{$master_lang_value}\";";
                        }
                    }
                }
            }
        }
    }

    return true;
}

// Master Language File.

$master_lang = load_language_file("en.inc.php");

// Slave Language Files.

$slave_langs = array("en-us.inc.php"    => array('lang' => load_language_file("en-us.inc.php"), 'showut' => false),
                     "x-hacker.inc.php" => array('lang' => load_language_file("x-hacker.inc.php"), 'showut' => false),
                     "fr-ca.inc.php"    => array('lang' => load_language_file("fr-ca.inc.php"), 'showut' => true),
                     "de.inc.php"       => array('lang' => load_language_file("de.inc.php"), 'showut' => true));

foreach ($slave_langs as $lang_name => $slave_lang) {

    if (isset($slave_lang['lang']) && is_array($slave_lang['lang'])) {

        $missing_key_results_array = array();
        $equal_value_results_array = array();
        $removed_key_results_array = array();

        echo $lang_name, "\n", str_repeat("=", strlen($lang_name)), "\n\n";

        if (compare_languages($master_lang, $slave_lang['lang'], $slave_lang['showut'], '+', '$lang', $missing_key_results_array)) {

            if (sizeof($missing_key_results_array) > 0) {

                foreach ($missing_key_results_array as $result_str) {

                    echo "+$result_str\n";
                }
            }

        }else {

            echo "Failed to do missing key comparison for language $lang_name\n\n";
        }

        if (compare_languages($master_lang, $slave_lang['lang'], $slave_lang['showut'], '=', '$lang', $equal_value_results_array)) {

            if (sizeof($equal_value_results_array) > 0) {

                foreach ($equal_value_results_array as $result_str) {

                    echo "=$result_str\n";
                }
            }

        }else {

            echo "Failed to do value comparison for language $lang_name\n\n";
        }

        if (compare_languages($slave_lang['lang'], $master_lang, false, '-', '$lang', $removed_key_results_array)) {

            if (sizeof($removed_key_results_array) > 0) {

                foreach ($removed_key_results_array as $result_str) {

                    echo "-$result_str\n";
                }
            }

        }else {

            echo "Failed to do removed key comparison for language $lang_name\n\n";
        }

        if (sizeof($missing_key_results_array) < 1 && sizeof($equal_value_results_array) < 1 && sizeof($removed_key_results_array) < 1) {

            echo "No Errors Found!\n\n";

        }else {

            echo "\n\n";
        }
    }
}

?>