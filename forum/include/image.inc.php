<?php

/*======================================================================
Copyright Project Beehive Forum 2002

This file is part of Beehive Forum.

Beehive Forum is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
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

// Required includes
require_once BH_INCLUDE_PATH . 'constants.inc.php';
require_once BH_INCLUDE_PATH . 'forum.inc.php';
// End Required includes

function image_enable_transparency($im)
{
    if (!function_exists('imagealphablending')) return $im;
    if (!function_exists('imagesavealpha')) return $im;

    imagealphablending($im, false);

    imagesavealpha($im, true);

    $transparent = imagecolorallocatealpha($im, 255, 255, 255, 127);

    imagefilledrectangle($im, 0, 0, imagesx($im), imagesy($im), $transparent);

    imagealphablending($im, true);

    return $im;
}

function image_read_function(array $image_info)
{
    // Required PHP image create from functions
    $required_read_functions = array(
        1 => 'imagecreatefromgif',
        2 => 'imagecreatefromjpeg',
        3 => 'imagecreatefrompng'
    );

    if (!function_exists($required_read_functions[$image_info[2]])) return false;

    return $required_read_functions[$image_info[2]];
}

function image_write_function(array $image_info)
{
    // Required PHP image output functions
    $required_write_functions = array(
        1 => 'imagegif',
        2 => 'imagejpeg',
        3 => 'imagepng'
    );

    // Even if GD says it supports the image format check the php functions actually exist!
    if (!function_exists($required_write_functions[$image_info[2]])) return false;

    return $required_write_functions[$image_info[2]];
}

function image_verify_functionality(array $image_info)
{
    // Required GD read support
    $required_read_support = array(
        1 => array('GIF Read Support'),
        2 => array('JPG Support', 'JPEG Support'),
        3 => array('PNG Support')
    );

    // Required GD write support
    $required_write_support = array(
        1 => array('GIF Create Support'),
        2 => array('JPG Support', 'JPEG Support'),
        3 => array('PNG Support')
    );

    // Check the gd_info function exists
    if (!function_exists('gd_info') || !($gd_info = gd_info())) return false;

    // Check the 'GD Version' key exists
    if (!isset($gd_info['GD Version']) || empty($gd_info['GD Version'])) return false;

    // Extract only the version number
    if (!preg_match('/\\d+\\.\\d+(?:\\.\\d+)?/', $gd_info['GD Version'], $gd_version)) return false;

    // Do we have a new enough version of GD?
    if (version_compare($gd_version[0], '2.0', '>=') === false) return false;

    // Is the image format in our list of supported image types.
    if (!isset($required_read_support[$image_info[2]])) return false;
    if (!isset($required_write_support[$image_info[2]])) return false;

    // Check gd_info function indicates support for the image type.
    if (!image_check_gd_info_key($required_read_support[$image_info[2]])) return false;
    if (!image_check_gd_info_key($required_write_support[$image_info[2]])) return false;

    return true;
}

function image_check_gd_info_key($image_types_array)
{
    if (!function_exists('gd_info') || !($gd_info = gd_info())) return false;

    if (!is_array($image_types_array)) return false;

    foreach ($image_types_array as $gd_info_key) {
        if (isset($gd_info[$gd_info_key]) && ($gd_info[$gd_info_key])) return true;
    }

    return false;
}

function image_resize($src, $dest, $max_width = 100, $max_height = 100)
{
    if (!is_numeric($max_width)) return false;
    if (!is_numeric($max_height)) return false;

    // Check the file exists and we can get some image data from it.
    if (!file_exists($src) || !($image_info = @getimagesize($src))) return false;

    // Check the destination directory is writable.
    if (!is_writable(dirname($dest))) return false;

    // Verify the GD image library has the required functionality
    if (!image_verify_functionality($image_info)) return false;

    // Fetch the image read function for the image type.
    if (!($image_read_function = image_read_function($image_info))) return false;

    // Fetch the image read function for the image type.
    if (!($image_write_function = image_write_function($image_info))) return false;

    // Can we actually read the image using the function?
    if (!($src_im = @$image_read_function($src))) return false;

    // Extract the dimensions from the image info.
    $image_width = $image_info[0];
    $image_height = $image_info[1];

    // Calculate image ratio
    $ratio = $image_info[1] / $image_info[0];

    // Scale the width and height till we fit in 1 of the dimensions.
    while (($image_width > $max_width) || ($image_height > $max_height)) {

        $image_width--;
        $image_height = floor($image_width * $ratio);
    }

    // Create a new true colour image
    $dest_im = imagecreatetruecolor($image_width, $image_height);

    // Fill the background in white.
    $dest_im = image_enable_transparency($dest_im);

    // Copy the source image onto the destination.
    imagecopyresampled($dest_im, $src_im, 0, 0, 0, 0, $image_width, $image_height, $image_info[0], $image_info[1]);

    // Write the file and return the result.
    return $image_write_function($dest_im, $dest);
}

function image_rotate($src)
{
    // Check the file exists and we can get some image data from it.
    if (!file_exists($src) || !($image_info = @getimagesize($src))) return false;

    // Fetch the image read function for the image type.
    if (!($image_read_function = image_read_function($image_info))) return false;

    // Fetch the image read function for the image type.
    if (!($image_write_function = image_write_function($image_info))) return false;

    // Check if exif_read_data function exists
    if (!function_exists('exif_read_data')) return false;

    // Can we read the exit data from the image?
    if (!($exif_data = @exif_read_data($src))) return false;

    // Can we actually read the image using the function?
    if (!($src_im = @$image_read_function($src))) return false;

    // Does the image contain the exif orientation data?
    if (!array_key_exists('Orientation', $exif_data)) return false;

    // Handle 180 degree rotation
    if (in_array($exif_data['Orientation'], [3, 4])) {
        $src_im = imagerotate($src_im, 180, 0);
    }

    // Handle 90 degree rotation
    if (in_array($exif_data['Orientation'], [5, 6])) {
        $src_im = imagerotate($src_im, -90, 0);
    }

    // Handle -90 degree rotation
    if (in_array($exif_data['Orientation'], [7, 8])) {
        $src_im = imagerotate($src_im, 90, 0);
    }

    // Handle horizontally flipped image
    if (in_array($exif_data['Orientation'], [2, 5, 7, 4])) {
        imageflip($src_im, IMG_FLIP_HORIZONTAL);
    }

    // Write the file and return the result.
    return $image_write_function($src_im, $src);
}
