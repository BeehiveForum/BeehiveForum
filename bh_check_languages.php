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

// Compare two language files.

function load_language_file($filename)
{
    include("./forum/include/languages/$filename");
    return $lang;
}

$en_lang = load_language_file("en.inc.php");
$ga_lang = load_language_file("fr.inc.php");

foreach ($en_lang as $key => $value) {

    if (!isset($ga_lang[$key])) {

        echo "\$lang['$key'] = \"$value\";\n";
    }
}

?>