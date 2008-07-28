<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

Beehive Forum is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Beehive; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307
USA
======================================================================*/

/* $Id: lang.inc.php,v 1.39 2008-07-28 21:05:53 decoyduck Exp $ */

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

if (@file_exists(BH_INCLUDE_PATH. "config.inc.php")) {
    include_once(BH_INCLUDE_PATH. "config.inc.php");
}

include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "session.inc.php");

function load_language_file()
{
    static $lang = false;

    if (!is_array($lang)) {

        // start out by including the English language file. This will allow
        // us to still use Beehive even if our language file isn't up to date
        // correctly.

        // The English language file must exist even if we're not going to be
        // using it in our forum. If we can't find it we'll bail out here.

        if (!file_exists(BH_INCLUDE_PATH. "languages/en.inc.php")) {
            trigger_error("<p>Could not load English language file (en.inc.php)</p>", E_USER_ERROR);
        }

        include(BH_INCLUDE_PATH. "languages/en.inc.php");

        $default_language = forum_get_setting('default_language', false, 'en');

         // if the user has expressed a preference for language,
         // ignore what the browser wants and use that if available

        if (($pref_language = bh_session_get_value("LANGUAGE"))) {

            if (@file_exists("include/languages/{$pref_language}.inc.php")) {

                include(BH_INCLUDE_PATH. "languages/{$pref_language}.inc.php");
                return $lang;
            }
        }

         // if the browser doesn't send an Accept-Language header, give up.

        if (!isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {

            include(BH_INCLUDE_PATH. "languages/{$default_language}.inc.php");
            return $lang;
        }

        // split the provided Accept-Language string into individual languages

        $langs_array = preg_split("/\s*,\s*/", $_SERVER['HTTP_ACCEPT_LANGUAGE']);

         // work out what the q values associated with each language are

        foreach ($langs_array as $key => $value) {

            if (strstr($value, ";q=")) {

                $bits = explode(";q=", $value);
                $langs_array[$key] = $bits[0];
                $qvalue[$key] = $bits[1];

            }else {

                $qvalue[$key] = 1;
            }
        }

        // sort the array in descending order of q value

        arsort($qvalue);

        // go through the array and use the first language installed that matches
        // if we've got to the stage where the user will accept any language,
        // default to what is specified in config.inc.php

        foreach ($qvalue as $key => $value) {

            if ($langs_array[$key] == "*") $langs_array[$key] = $default_language;

            if (@file_exists("include/languages/{$langs_array[$key]}.inc.php")) {

                include(BH_INCLUDE_PATH. "languages/{$langs_array[$key]}.inc.php");
                return $lang;
            }
        }

        // if we're still here, no languages matched. Use the default specified in config.inc.php
        include(BH_INCLUDE_PATH. "languages/{$default_language}.inc.php");
        return $lang;
    }

    return $lang;
}

function lang_get_available($inc_browser_negotiation = true)
{
    $lang = load_language_file();

    $available_langs = ($inc_browser_negotiation) ? array('' => $lang['browsernegotiation']) : array();

    if ((@$dir = opendir("include/languages"))) {

        while (($file = readdir($dir))) {

            if (($pos = strpos($file, '.inc.php')) !== false) {

                $lang_name = substr($file, 0, $pos);
                $available_langs[$lang_name] = $lang_name;
            }
        }

        closedir($dir);
    }

    asort($available_langs);

    return $available_langs;
}

?>