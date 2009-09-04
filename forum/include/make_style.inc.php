<?php

/*======================================================================
Copyright Project Beehive Forum 2003

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

/* $Id: make_style.inc.php,v 1.32 2009-09-04 22:01:45 decoyduck Exp $ */

/**
* make_style.inc.php - attachment upload handling
*
* Contains functions for creating forum styles. Concept and original code by Andrew Holgate
*/

/**
*
*/

// We shouldn't be accessing this file directly.

if (basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

include_once(BH_INCLUDE_PATH. "compat.inc.php");
include_once(BH_INCLUDE_PATH. "constants.inc.php");
include_once(BH_INCLUDE_PATH. "admin.inc.php");
include_once(BH_INCLUDE_PATH. "forum.inc.php");
include_once(BH_INCLUDE_PATH. "server.inc.php");

/**
* Saves the forum style
*
* Saves the named forum style to the server.
*
* @return bool
* @param string $style_name - name of the style to use as the folder name
* @param string $style_desc - description of the style to write to desc.txt
* @param string $content - CSS style sheet contents to write to style.css
* @param integer $error - By-Reference error message.
*/

function forum_save_style($style_name, $style_desc, $content, &$error)
{
    $webtag = get_webtag();

    if (!forum_check_webtag_available($webtag)) return false;

    // Check for invalid filename

    if (preg_match("/^[a-z0-9_]+$/Diu", $style_name) < 1) return false;

    // Check to see if the style name is already in use in this forum

    if (@file_exists("forums/$webtag/styles/$style_name/style.css")) {

        $error = STYLE_ALREADY_EXISTS;
        return false;
    }

    // Check to see if the style name is already in use globally.

    if (@file_exists("styles/$style_name/style.css")) {

        $error = STYLE_ALREADY_EXISTS;
        return false;
    }

    // Check that the directory structure exists

    mkdir_recursive("forums/$webtag/styles/$style_name", 0755);

    // Save the style desc.txt file

    if (@file_put_contents("forums/$webtag/styles/$style_name/desc.txt", $style_desc)) {

        if (@file_put_contents("forums/$webtag/styles/$style_name/style.css", $content)) {

            return true;
        }
    }

    // Undo the mkdir_recursive call above.

    rmdir_recursive("forums/$webtag/styles/$style_name");

    // And we're out of here ...

    $error = STYLE_WRITE_ERROR;
    return false;
}

// Function to convert decimal RGB values to their Hex equivelent.

function decToHex ($r, $g, $b)
{
    return (str_pad(dechex($r), 2, '0', STR_PAD_RIGHT).
            str_pad(dechex($g), 2, '0', STR_PAD_RIGHT).
            str_pad(dechex($b), 2, '0', STR_PAD_RIGHT));
}


// Function to convert Hex colour value to decimal RGB components

function hexToDec ($rgb)
{

    $r = mb_substr ($rgb, 0, 2);
    $g = mb_substr ($rgb, 2, 2);
    $b = mb_substr ($rgb, 4, 2);

    return array(hexdec($r), hexdec($g), hexdec($b));

}

function changeColour ($r, $g, $b, $variance, $mode, $steps)
{
    if (mt_rand(0, 20) == 1 and $mode == "rand") {

        $r1 = $r;
        $g1 = $g;
        $b1 = $b;

        $r = $g1;
        $g = $b1;
        $b = $r1;
    }

    $plus_minus = array (1, -1);

    if ($mode == "rand") {
        $newr = $r + ((mt_rand(0, $variance * 2) + $variance) * $plus_minus[rand(0, 1)]);
    }else {
        $rarr = ((255-$r) / $steps) + (((255 - $r) / $steps) * (3 / 5));
        if ($rarr < 1) $rarr = 1;
        $newr = $r + mt_rand(0, $rarr);
    }

    if ($newr > 255) {
        $newr = 255;
    }else if ($newr < 0) {
        $newr = 0;
    }

    if ($mode == "rand") {
        $newg = $g + ((mt_rand(0, $variance * 2) + $variance) * $plus_minus[rand(0, 1)]);
    }else {
        $rarg = ((255 - $g) / $steps) + (((255 - $g) / $steps) * (3 / 5));
        if ($rarg < 1) $rarg = 1;
        $newg = $g + mt_rand(0, $rarg);
    }

    if ($newg > 255) {
        $newg = 255;
    }else if ($newg < 0) {
        $newg = 0;
    }

    if ($mode == "rand") {
        $newb = $b + ((mt_rand(0, $variance * 2) + $variance) * $plus_minus[rand(0, 1)]);
    }else {
        $rarb = ((255 - $b) / $steps) + (((255 - $b) / $steps) * (3 / 5));
        if ($rarb < 1) $rarb = 1;
        $newb = $b + mt_rand(0, $rarb);
    }

    if ($newb > 255) {
        $newb = 255;
    }else if ($newb < 0) {
        $newb = 0;
    }

    return (decToHex($newr, $newg, $newb));
}

// Random number shiznit

function rand_sort()
{
    return (mt_rand(0, 1));
}

// calculates the luminance, saturation and hue of a supplied
// background colour and uses the data to chooses between white
// or black for the font colour of the supplied.

function contrastFont($hex)
{

    list ($r, $g, $b) = hexToDec($hex);
    $rgb = array((double)$r / 255, (double)$g / 255, (double)$b / 255);
    sort($rgb);

    $lum = ($rgb[2] + $rgb[0]) / 2;

    if ($rgb[2] == $rgb[0]) {
        $sat = 0;
        $hue = 0;
    }else {

        if ($lum < 0.5) {
            $sat = ($rgb[2] - $rgb[0]) / ($rgb[2] + $rgb[0]);
        }else {
            $sat = ($rgb[2] - $rgb[0]) / (2 - $rgb[2] - $rgb[0]);
        }

        if (($rgb[2] * 255) == $r) {
            $hue = ($g - $b) / ($rgb[2] - $rgb[0]);
        }elseif (($rgb[2] * 255) == $g) {
            $hue = 2 + ($b - $r) / ($rgb[2] - $rgb[0]);
        }elseif (($rgb[2] * 255) == $b) {
            $hue = 4 + ($r - $g) / ($rgb[2] - $rgb[0]);
        }else {
            $hue = 0;
        }

        $hue /= 6;
        if ($hue < 0) $hue += 1;

    }

    if ($sat > 0.8 && (($rgb[2] * 255) == $b && $r < 128 && $g < 128)) {
        $text_colour = "FFFFFF";
    }elseif ($sat > 0.8) {
        if ($lum < 0.4) {
            $text_colour = "FFFFFF";
        }else {
            $text_colour = "000000";
        }
    }else {
        if ($lum < 0.6) {
            $text_colour = "FFFFFF";
        }else {
            $text_colour = "000000";
        }
    }

    return $text_colour;

}

?>