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

// Compresses the output of the PHP scripts to save bandwidth.

require_once('./include/config.inc.php');

function bh_check_gzip()
{
    global $HTTP_SERVER_VARS, $gzip_compress_output;

    if (headers_sent() || $gzip_compress_output == false) {
        return false;
    }

    if (strpos($HTTP_SERVER_VARS['HTTP_ACCEPT_ENCODING'], 'x-gzip') !== false) return "x-gzip";
    if (strpos($HTTP_SERVER_VARS['HTTP_ACCEPT_ENCODING'], 'gzip') !== false) return "gzip";

    return false;
}

function bh_gzhandler($contents)
{
    global $gzip_compress_level;

    if ($gzip_compress_level > 9) $gzip_compress_level = 9;
    if ($gzip_compress_level < 1) $gzip_compress_level = 1;

    if ($encoding = bh_check_gzip()) {

        $contents.= "<!-- bh_gzhandler: $encoding enabled (level: $gzip_compress_level) //-->\n";

        $gzcontent = gzcompress($contents, $gzip_compress_level);
        $size      = strlen($contents);
        $crc32     = crc32($contents);

        header("Etag: VT$crc32");
        header("Content-Encoding: $encoding");

        $ret = "\x1f\x8b\x08\x00\x00\x00\x00\x00";
        $ret.= substr($gzcontent, 0, strlen($gzcontent) - 4);
        $ret.= pack('V', $crc32);
        $ret.= pack('V', $size);

        return $ret;

    }else {

        $contents.= "<!-- bh_gzhandler: compression disabled //-->\n";
        return $contents;

    }


}

ob_start("bh_gzhandler");

?>