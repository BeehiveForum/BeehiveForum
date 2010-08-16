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

/* $Id$ */

// We shouldn't be accessing this file directly.
if (basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "format.inc.php");
include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "lang.inc.php");

/**
* styles_get_available
* 
* Get the styles available on the forum. Returns
* a key value pair array with the key as the name
* of the style and the value the name of the directory
* the style is in.
* 
* @param void
* @return mixed 
*/
function styles_get_available()
{
    // Array to store our styles in.
    $available_forum_styles  = array();

    // Try and open the styles directory for reading.
    if (!(@$dir = opendir("styles"))) return false;
    
    // Iterate over the entries in the directory.
    while (($file = readdir($dir)) !== false) {

        // Check the entry is a directory excluding . and ..
        if (!is_dir("styles/$file") || $file == '.' || $file == '..') continue;

        // Check a style.css exists in it.
        if (!file_exists("styles/$file/style.css")) continue;

        // Look for a desc.txt to use in place of the directory name.
        if (file_exists("styles/$file/desc.txt") && is_readable("styles/$file/desc.txt")) {

            // Add the style to the list with the contents of desc.txt as the name.
            $available_forum_styles[$file] = htmlentities_array(trim(file_get_contents("styles/$file/desc.txt")));

        }else {

            // Add the style to the list using the directory name
            $available_forum_styles[$file] = htmlentities_array(trim($file));
        }
    }

    // Close the directory handle.
    closedir($dir);

    // Check we have something to return.
    if (sizeof($available_forum_styles) < 1) return false;
        
    // Sort the styles alphabetically.
    asort($available_forum_styles);
    
    // Reset the array pointer.
    reset($available_forum_styles);
        
    // Return the styles.
    return $available_forum_styles;
}

/**
* style_exists
* 
* Check a named style exists.
* 
* @param string $style_path
* @return bool.
*/
function style_exists($style_path)
{
    // Check the style path is a string.
    if (!is_string($style_path)) return false;

    // Extract only the filename part.
    $style_path = basename($style_path);
    
    // Check if a style.css exists in the path.
    return file_exists("styles/$style_path/style.css");
}

?>