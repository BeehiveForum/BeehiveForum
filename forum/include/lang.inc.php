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

/* $Id: lang.inc.php,v 1.21 2005-03-15 21:30:03 decoyduck Exp $ */

if (@file_exists("./include/config.inc.php")) {
    include_once(BH_INCLUDE_PATH. "config.inc.php");
}

include_once(BH_INCLUDE_PATH. "forum.inc.php");

function load_language_file()
{
    static $lang = false;

    if (!$lang) {

        $default_language = forum_get_setting('default_language', false, 'en');

         // if the user has expressed a preference for language,
         // ignore what the browser wants and use that if available

        if ($pref_language = bh_session_get_value("LANGUAGE")) {

            if (@file_exists("./include/languages/{$pref_language}.inc.php")) {

                include_once(BH_INCLUDE_PATH. "languages/{$pref_language}.inc.php");
                return $lang;
            }
        }

         // if the browser doesn't send an Accept-Language header, give up.

        if (!isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            include_once(BH_INCLUDE_PATH. "languages/{$default_language}.inc.php");
            return $lang;
        }

        // split the provided Accept-Language string into individual languages

        $langs = preg_split("/\s*,\s*/", $_SERVER['HTTP_ACCEPT_LANGUAGE']);

         // work out what the q values associated with each language are

        foreach ($langs as $key => $value) {
            if (strstr($value, ";q=")) {
                $bits = explode(";q=", $value);
                $langs[$key] = $bits[0];
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

            if ($langs[$key] == "*") $langs[$key] = $default_language;

            if (@file_exists("./include/languages/{$langs[$key]}.inc.php")) {

                include_once(BH_INCLUDE_PATH. "languages/{$langs[$key]}.inc.php");
                return $lang;
            }
        }

        // if we're still here, no languages matched. Use the default specified in config.inc.php
        include_once ("./include/languages/{$default_language}.inc.php");
    }

    return $lang;
}

function lang_get_available()
{
    $available_langs = array();

    if (@$dir = opendir("./include/languages")) {

        while ($file = readdir($dir)) {

            if (strpos($file, '.inc.php') !== false) {

                array_push($available_langs, substr($file, 0, strpos($file, '.inc.php')));
            }
        }

        closedir($dir);
    }

    return $available_langs;
}

?>