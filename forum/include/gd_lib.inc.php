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

/* $Id: gd_lib.inc.php,v 1.9 2008-08-20 19:02:59 decoyduck Exp $ */

/**
* gd_lib.inc.php - GD image library functions
*
* Contains GD image library related functions
*/

/**
*
*/

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

/**
* Checks for GD image library support
*
* Queries the phpinfo function for GD image library and returns the supported image and font types in an associative array.
*
* @return array
* @param void
*/

function get_gd_info()
{
    $get_gd_info = array('GD Version'       => false, 'FreeType Support'   => 0,
                         'FreeType Linkage' => '',    'T1Lib Support'      => 0,
                         'GIF Read Support' => 0,     'GIF Create Support' => 0,
                         'JPG Support'      => 0,     'PNG Support'        => 0,
                         'WBMP Support'     => 0,     'XBM Support'        => 0);
    $gif_support = 0;

    ob_start();
    eval('phpinfo();');
    $php_info = ob_get_contents();
    ob_end_clean();

    foreach (explode("\n", $php_info) as $line) {

        if (strpos($line, 'GD Version') !== false) {
            $get_gd_info['GD Version'] = preg_replace('/[^0-9|\.]/u', '', trim(str_replace('GD Version', '', strip_tags($line))));
        }

        if (strpos($line, 'FreeType Support') !== false) {
            $get_gd_info['FreeType Support'] = trim(str_replace('FreeType Support', '', strip_tags($line)));
        }

        if (strpos($line, 'FreeType Linkage') !== false) {
            $get_gd_info['FreeType Linkage'] = trim(str_replace('FreeType Linkage', '', strip_tags($line)));
        }

        if (strpos($line, 'T1Lib Support') !== false) {
            $get_gd_info['T1Lib Support'] = trim(str_replace('T1Lib Support', '', strip_tags($line)));
        }

        if (strpos($line, 'GIF Read Support') !== false) {
            $get_gd_info['GIF Read Support'] = trim(str_replace('GIF Read Support', '', strip_tags($line)));
        }

        if (strpos($line, 'GIF Create Support') !== false) {
            $get_gd_info['GIF Create Support'] = trim(str_replace('GIF Create Support', '', strip_tags($line)));
        }

        if (strpos($line, 'GIF Support') !== false) {
            $gif_support = trim(str_replace('GIF Support', '', strip_tags($line)));
        }

        if (strpos($line, 'JPG Support') !== false) {
            $get_gd_info['JPG Support'] = trim(str_replace('JPG Support', '', strip_tags($line)));
        }

        if (strpos($line, 'PNG Support') !== false) {
            $get_gd_info['PNG Support'] = trim(str_replace('PNG Support', '', strip_tags($line)));
        }

        if (strpos($line, 'WBMP Support') !== false) {
            $get_gd_info['WBMP Support'] = trim(str_replace('WBMP Support', '', strip_tags($line)));
        }

        if (strpos($line, 'XBM Support') !== false) {
            $get_gd_info['XBM Support'] = trim(str_replace('XBM Support', '', strip_tags($line)));
        }
    }

    if ($gif_support === 'enabled') {
        $get_gd_info['GIF Read Support']  = 1;
        $get_gd_info['GIF Create Support'] = 1;
    }

    if ($get_gd_info['FreeType Support'] === 'enabled') {
        $get_gd_info['FreeType Support'] = 1;
    }

    if ($get_gd_info['T1Lib Support'] === 'enabled') {
        $get_gd_info['T1Lib Support'] = 1;
    }

    if ($get_gd_info['GIF Read Support'] === 'enabled') {
        $get_gd_info['GIF Read Support'] = 1;
    }

    if ($get_gd_info['GIF Create Support'] === 'enabled') {
        $get_gd_info['GIF Create Support'] = 1;
    }

    if ($get_gd_info['JPG Support'] === 'enabled') {
        $get_gd_info['JPG Support'] = 1;
    }

    if ($get_gd_info['PNG Support'] === 'enabled') {
        $get_gd_info['PNG Support'] = 1;
    }

    if ($get_gd_info['WBMP Support'] === 'enabled') {
        $get_gd_info['WBMP Support'] = 1;
    }

    if ($get_gd_info['XBM Support'] === 'enabled') {
        $get_gd_info['XBM Support'] = 1;
    }

   return $get_gd_info;
}

?>