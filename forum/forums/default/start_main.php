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

/* $Id: start_main.php,v 1.6 2004-11-06 20:26:25 decoyduck Exp $ */

// An example of what can be done with start_main.php
// As used on: http://www.tehforum.net/forum/

function formatname($filename)
{
    if ($pos = strrpos($filename, '.')) {
        $name = substr($filename, 0, $pos);
        $name = str_replace('_', ' ', $name);
    }

    return $name;
}

// Where are the images stored?

$images_dir = 'images/forumites';

// Initialise the array to store the images in

$images_array = array();

// Get the files here

if ($dir = @opendir($images_dir)) {

    while(($file = readdir($dir)) !== false) {
        if ($file != '.' && $file != '..') {
            $images_array[] = $file;
        }
    }

    closedir($dir);
}

// Sort the files by name ASC

sort($images_array);

// Check the URL parameters for a specific ID

if (isset($HTTP_GET_VARS['id']) && is_numeric($HTTP_GET_VARS['id'])) {
    if (isset($images_array[$HTTP_GET_VARS['id']])) {
        $id = $HTTP_GET_VARS['id'];
    }
}

// If we don't have an ID generate a random one

if (!isset($id) && sizeof($images_array) > 0) {
    srand((double)microtime() * 1000000);
    $id = rand(0, sizeof($images_array) - 1);
}

// Get the properties of the random/selected image.

list($width, $height, $type, $html) = @getimagesize("{$images_dir}/{$images_array[$id]}");

echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.0 Transitional//EN\" \"http://www.w3.org/TR/REC-html40/loose.dtd\">\n";
echo "<html>\n";
echo "<head>\n";
echo "<title>Teh Forum - Forumite Gallery</title>\n";
echo "<style type=\"text/css\">\n";
echo "<!--\n\n";
echo ".bodytext    { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px;\n";
echo "               font-style: normal; line-height: 13px; font-weight: normal; color: #666666;\n";
echo "               background-color: #EAEFF4 }\n\n";
echo ".image       { position: absolute; position: absolute; left: 50%; top: 50%; width: {$width}px;\n";
echo "               height: {$height}px; margin-left: -", round($width / 2), "px; margin-top: -", round($height / 2), "px }\n\n";
echo ".title       { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 18px;\n";
echo "               font-style: normal; font-weight: bold; color: #ffffff; background-color: #A6BED7 }\n";
echo "a            { font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px;\n";
echo "               line-height: 13px; font-weight: normal; color: #333399;\n";
echo "               text-decoration: underline }\n\n";
echo "//-->\n";
echo "</style>\n";
echo "</head>\n\n";
echo "<body class=\"bodytext\">\n";

if (isset($HTTP_GET_VARS['gallery'])) {

    echo "<div align=\"center\">\n";
    echo "<table border=\"0\" cellpadding=\"10\" cellspacing=\"10\" width=\"500\">\n";

    for ($i = 0; $i < sizeof($images_array); $i++) {  // $i+=2

        list($width, $height, $type, $html) = @getimagesize($images_dir.$images_array[$i]);

        echo "  <tr>\n";
        echo "    <td align=\"center\">\n";
        echo "      <p><a href=\"{$HTTP_SERVER_VARS['PHP_SELF']}\"><img src=\"{$images_dir}/{$images_array[$i]}\" {$html} border=\"0\" alt=\"", formatname($images_array[$i]), "\" title=\"", formatname($images_array[$i]), "\" /></a></p>\n";
        echo "      <p class=\"bodytext\">", formatname($images_array[$i]), "</p>\n";
        echo "    </td>\n";
        echo "  </tr>\n";
    }

    echo "</table>\n";
    echo "</div>\n";

}else {

    if (isset($id) && isset($images_array[$id])) {

        echo "<div class=\"image\">\n";
        echo "<p><img src=\"{$images_dir}/{$images_array[$id]}\" {$html} border=\"0\" alt=\"", formatname($images_array[$id]), "\" title=\"", formatname($images_array[$id]), "\" /></p>\n";
        echo "<p><div align=\"center\">", formatname($images_array[$id]), "</div></p>\n";
        echo "<p><div align=\"center\">[<a href=\"{$HTTP_SERVER_VARS['PHP_SELF']}\">Random Image</a> | <a href=\"{$HTTP_SERVER_VARS['PHP_SELF']}?gallery=true\">Gallery</a>]</div></p>\n";
        echo "</div>\n";

    }else {

        echo "<p>Upload the images doofus!</p>\n";
    }
}

?>
</body>
</html>