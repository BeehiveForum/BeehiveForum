<?php

/*======================================================================
Copyright Project BeehiveForum 2003

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

// Concept and Original code: Andrew Holgate
// Beehive-fitter-iner and dogs body: Matt Beale


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

    $r = substr ($rgb, 0, 2);
    $g = substr ($rgb, 2, 2);
    $b = substr ($rgb, 4, 2);

    return array(hexdec($r), hexdec($g), hexdec($b));

}

function changeColour ($r, $g, $b, $variance, $mode, $steps)
{

    if (rand(0, 20) == 1 and $mode == "rand") {
        $r1 = $r;
        $g1 = $g;
        $b1 = $b;

        $r = $g1;
        $g = $b1;
        $b = $r1;
    }

    $plus_minus = array (1, -1);

    if ($mode == "rand") {
        $newr = $r + ((rand(0, $variance * 2) + $variance) * $plus_minus[rand(0, 1)]);
    } else {
        $rarr = ((255-$r) / $steps) + (((255 - $r) / $steps) * (3 / 5));
        if ($rarr < 1) $rarr = 1;
        $newr = $r + rand(0, $rarr);
    }

    if ($newr > 255) {
        $newr = 255;
    }else if ($newr < 0) {
        $newr = 0;
    }

    if ($mode == "rand") {
        $newg = $g + ((rand(0, $variance * 2) + $variance) * $plus_minus[rand(0, 1)]);
    }else {
        $rarg = ((255 - $g) / $steps) + (((255 - $g) / $steps) * (3 / 5));
        if ($rarg < 1) $rarg = 1;
        $newg = $g + rand(0, $rarg);
    }

    if ($newg > 255) {
        $newg = 255;
    }else if ($newg < 0) {
        $newg = 0;
    }

    if ($mode == "rand") {
        $newb = $b + ((rand(0, $variance * 2) + $variance) * $plus_minus[rand(0, 1)]);
    }else {
        $rarb = ((255 - $b) / $steps) + (((255 - $b) / $steps) * (3 / 5));
        if ($rarb < 1) $rarb = 1;
        $newb = $b + rand(0, $rarb);
    }

    if ($newb > 255) {
        $newb = 255;
    }else if ($newb < 0) {
        $newb = 0;
    }

    return (decToHex($newr, $newg, $newb));
}

// Random number shiznit

function randSort()
{

    return (rand(0, 1));

}

// chooses between white and black for the font colour
// based on the luminance of the supplied background colour.

function contrastFont($hex, $lum_level = 0.6) {

    list ($r, $g, $b) = hexToDec($hex);
    $rgb = array($r / 255, $g / 255, $b / 255);

    sort($rgb);

    $luminance = ($rgb[2] + $rgb[0]) / 2;

    if ($luminance < $lum_level) {
        $text_colour = "FFFFFF";
    }else {
        $text_colour = "000000";
    }

    return $text_colour;

}

?>