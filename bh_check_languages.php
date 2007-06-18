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

/* $Id: bh_check_languages.php,v 1.32 2007-06-18 20:10:49 decoyduck Exp $ */

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
                return parse_lang_data($array_key, $array_data, "{$prefix}['$key']");
            }else {
                return parse_lang_data($array_key, $array_data, "{$prefix}[$key]");
            }
        }

    }else {

        if (!preg_match("/^_/", $key)) {
       
            $data = str_replace("\n", "\\n", $data);
            
            if (is_string($key)) {
                return "{$prefix}['$key'] = \"$data\";";
            }else {
                return "{$prefix}[$key] = \"$data\";";
            }
        }
    }

    return false;
}

// Master Language File.

$master_lang = load_language_file("en.inc.php");

// Slave Language Files.

$slave_langs = array("x-hacker.inc.php" => array('lang' => load_language_file("x-hacker.inc.php"), 'showut' => false),
                     "fr-ca.inc.php"    => array('lang' => load_language_file("fr-ca.inc.php"), 'showut' => true),
                     "de.inc.php"       => array('lang' => load_language_file("de.inc.php"), 'showut' => true));

foreach ($slave_langs as $lang_name => $slave_lang) {

    if (isset($slave_lang['lang']) && is_array($slave_lang['lang'])) {
    
        echo $lang_name, "\n", str_repeat("=", strlen($lang_name)), "\n\n";

        $strings = $slave_lang['lang'];

        $error_array = array();

        foreach ($master_lang as $key => $value) {

            if (!isset($strings[$key])) {

                if ($error = parse_lang_data($key, $value, '+$lang')) {

                    $error_array['slave_unset'][] = $error;
                }

            }elseif (($strings[$key] == $value) && ($slave_lang['showut'] === true)) {

                if ($error = parse_lang_data($key, $value, '=$lang')) {

                    $error_array['untranslated'][] = $error;
                }
            }
        }

        foreach ($strings as $key => $value) {

            if (!isset($master_lang[$key])) {

                if ($error = parse_lang_data($key, $value, '-$lang')) {

                    $error_array['master_unset'][] = $error;
                }
            }
        }

        if (sizeof($error_array) > 0) {

            if (isset($error_array['slave_unset']) && sizeof($error_array['slave_unset']) > 0) {

                foreach($error_array['slave_unset'] as $slave_unset) {
                    echo $slave_unset, "\n";
                }
            }

            if (isset($error_array['untranslated']) && sizeof($error_array['untranslated']) > 0) {

                foreach($error_array['untranslated'] as $untranslated) {
                    echo $untranslated, "\n";
                }
            }

            if (isset($error_array['master_unset']) && sizeof($error_array['master_unset']) > 0) {

                foreach($error_array['master_unset'] as $master_unset) {
                    echo $master_unset, "\n";
                }
            }

            echo "\n\n";

        }else {

            echo "No Errors Found!\n\n";
        }
    }
}

?>