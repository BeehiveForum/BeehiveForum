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

/* $Id: lang.inc.php,v 1.7 2004-03-11 22:34:38 decoyduck Exp $ */

// I18N SUPPORT

include_once("./include/config.inc.php");
include_once("./include/ip.inc.php");
include_once("./include/stats.inc.php");
include_once("./include/session.inc.php");

bh_session_check();

if (!isset($default_language)) $default_language = "en";
$pref_language = bh_session_get_value("LANGUAGE");

if ($pref_language && $pref_language != "") { // if the user has expressed a preference for language, ignore what the browser wants and use that if available
   if (file_exists("./include/languages/".$pref_language.".inc.php")) {
        include_once("./include/languages/".$pref_language.".inc.php");
        return;
    }
}

if (!isset($HTTP_SERVER_VARS['HTTP_ACCEPT_LANGUAGE'])) {
   include_once("./include/languages/$default_language.inc.php"); // if the browser doesn't send an Accept-Language header, give up.
   return;
}

$langs = preg_split("/\s*,\s*/", $HTTP_SERVER_VARS['HTTP_ACCEPT_LANGUAGE']); // split the provided Accept-Language string into individual languages

foreach ($langs as $key => $value) { // work out what the q values associated with each language are
    if (strstr($value, ";q=")) {
       $bits = explode(";q=", $value);
       $langs[$key] = $bits[0];
       $qvalue[$key] = $bits[1];
    } else {
       $qvalue[$key] = 1;
    }
}

arsort($qvalue); // sort the array in descending order of q value

foreach ($qvalue as $key => $value) { // go through the array and use the first language installed that matches
    if ($langs[$key] == "*") $langs[$key] = $default_language; // if we've got to the stage where the user will accept any language, default to what is specified in config.inc.php
    if (file_exists("./include/languages/".$langs[$key].".inc.php")) {
        include_once("./include/languages/".$langs[$key].".inc.php");
        return;
    }
}

// if we're still here, no languages matched. Use the default specified in config.inc.php
include_once ("./include/languages/$default_language.inc.php");

function lang_get_available()
{
    $available_langs = array();
    $dir = opendir("./include/languages");
    while ($item = readdir($dir)) {
        if (strpos($item, '.inc.php') !== false) array_push($available_langs, substr($item, 0, strpos($item, '.inc.php')));
    }
    closedir($dir);
    return $available_langs;
}

?>