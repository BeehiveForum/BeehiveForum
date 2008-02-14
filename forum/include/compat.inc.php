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

/* $Id: compat.inc.php,v 1.1 2008-02-14 23:02:47 decoyduck Exp $ */

/**
* compat.inc.php - Compatibility functions
*
* Contains functions for compatibility with older versions of PHP.
*/

// We shouldn't be accessing this file directly.

if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    header("Request-URI: ../index.php");
    header("Content-Location: ../index.php");
    header("Location: ../index.php");
    exit;
}

if (!function_exists('file_put_contents')) {

    if (!defined('FILE_APPEND')) define('FILE_APPEND', 1);

    function file_put_contents($file, $content, $flag = false)
    {
        $mode = ($flag == FILE_APPEND || strtoupper($flag) == 'FILE_APPEND') ? 'a' : 'w';

        if (($fp = @fopen($file, $mode)) !== false) {

            if (is_array($content)) $content = implode($content);

            $bytes = fwrite($fp, $content);

            fclose($fp);

            return $bytes;
        }

        return false;
    }
}

?>